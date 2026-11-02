<?php

declare(strict_types=1);

/*
 * Génère les modèles du SDK (src/Model) à partir des définitions du swagger de l'API.
 *
 * Usage : php bin/generate-models.php <swagger.json> <dossier de sortie>
 *
 * Seuls les modèles sont générés : les endpoints sont écrits à la main dans src/Api,
 * car le swagger produit par swag ne décrit pas toujours fidèlement les réponses.
 */

const MARKER = 'Généré par bin/generate-models.php';
const NAMESPACE_MODEL = 'EntreprisePage\\ApiClient\\Model';

/** Corrige les noms de définitions peu parlants ou mal orthographiés côté API. */
const RENAMES = [
    'Coordoonnees' => 'Coordonnees',
    'Search' => 'RechercheEntreprise',
];

$args = $_SERVER['argv'] ?? null;
if (!is_array($args) || 3 !== count($args) || !is_string($args[1]) || !is_string($args[2])) {
    fwrite(\STDERR, "Usage : php bin/generate-models.php <swagger.json> <dossier de sortie>\n");
    exit(1);
}

[, $swaggerPath, $outputDir] = $args;

$swagger = json_decode((string) file_get_contents($swaggerPath), true, 512, \JSON_THROW_ON_ERROR);
if (!is_array($swagger) || !is_array($swagger['definitions'] ?? null)) {
    fwrite(\STDERR, "Aucune définition trouvée dans {$swaggerPath}\n");
    exit(1);
}

if (!is_dir($outputDir) && !mkdir($outputDir, 0777, true)) {
    fwrite(\STDERR, "Impossible de créer {$outputDir}\n");
    exit(1);
}

foreach (glob($outputDir.'/*.php') ?: [] as $existing) {
    if (false !== strpos((string) file_get_contents($existing), MARKER)) {
        unlink($existing);
    }
}

foreach ($swagger['definitions'] as $name => $definition) {
    $class = className((string) $name);
    file_put_contents($outputDir.'/'.$class.'.php', renderClass($class, schema($definition, (string) $name)));
}

function className(string $definition): string
{
    return RENAMES[$definition] ?? $definition;
}

/**
 * @param mixed $value
 *
 * @return array<mixed>
 */
function schema($value, string $context): array
{
    if (!is_array($value)) {
        throw new RuntimeException("Schéma invalide pour {$context}");
    }

    return $value;
}

function camelCase(string $snake): string
{
    return lcfirst(str_replace('_', '', ucwords($snake, '_')));
}

/**
 * @param array<mixed> $schema
 *
 * @return array{php: string, doc: string|null, read: string}
 */
function resolveType(array $schema, string $key, bool $nullable): array
{
    $allOf = is_array($schema['allOf'] ?? null) ? $schema['allOf'] : [];
    $ref = $schema['$ref'] ?? (isset($allOf[0]) ? schema($allOf[0], $key)['$ref'] ?? null : null);
    if (is_string($ref)) {
        $class = className(substr($ref, strlen('#/definitions/')));

        return [
            'php' => ($nullable ? '?' : '').$class,
            'doc' => null,
            'read' => sprintf('Data::%s($data, \'%s\', [%s::class, \'fromArray\'])', $nullable ? 'nullableObject' : 'object', $key, $class),
        ];
    }

    $type = $schema['type'] ?? null;
    if ('array' === $type) {
        $items = is_array($schema['items'] ?? null) ? $schema['items'] : [];
        $itemRef = $items['$ref'] ?? null;
        if (is_string($itemRef)) {
            $class = className(substr($itemRef, strlen('#/definitions/')));

            return ['php' => 'array', 'doc' => "list<{$class}>", 'read' => sprintf('Data::objectList($data, \'%s\', [%s::class, \'fromArray\'])', $key, $class)];
        }
        if ('string' === ($items['type'] ?? null)) {
            return ['php' => 'array', 'doc' => 'list<string>', 'read' => sprintf('Data::stringList($data, \'%s\')', $key)];
        }

        throw new RuntimeException("Type de liste non géré pour {$key}");
    }

    $scalars = [
        'string' => ['string', 'String'],
        'integer' => ['int', 'Int'],
        'number' => ['float', 'Float'],
        'boolean' => ['bool', 'Bool'],
    ];
    if (!is_string($type) || !isset($scalars[$type])) {
        throw new RuntimeException(sprintf('Type "%s" non géré pour %s', var_export($type, true), $key));
    }
    [$php, $reader] = $scalars[$type];

    return [
        'php' => ($nullable ? '?' : '').$php,
        'doc' => null,
        'read' => sprintf('Data::%s($data, \'%s\')', $nullable ? 'nullable'.$reader : lcfirst($reader), $key),
    ];
}

/**
 * @param array<mixed> $definition
 */
function renderClass(string $class, array $definition): string
{
    $properties = [];
    foreach (schema($definition['properties'] ?? [], 'properties') as $key => $property) {
        $properties[(string) $key] = schema($property, (string) $key);
    }

    // swag trie les propriétés par ordre alphabétique ; x-order permet d'en remonter certaines.
    $order = static fn (string $key): ?int => is_numeric($properties[$key]['x-order'] ?? null) ? (int) $properties[$key]['x-order'] : null;
    $keys = array_keys($properties);
    usort($keys, static function (string $a, string $b) use ($order): int {
        if (null !== $order($a) && null !== $order($b)) {
            return $order($a) <=> $order($b);
        }
        if (null !== $order($a) || null !== $order($b)) {
            return null !== $order($a) ? -1 : 1;
        }

        return strcmp($a, $b);
    });

    $declarations = [];
    $params = [];
    $paramDocs = [];
    $assignments = [];
    $reads = [];
    foreach ($keys as $key) {
        $schema = $properties[$key];
        $nullable = true === ($schema['x-nullable'] ?? false);
        $type = resolveType($schema, $key, $nullable);
        $property = camelCase($key);

        $doc = [];
        if (is_string($schema['description'] ?? null)) {
            $doc[] = (string) preg_replace('/\s+/', ' ', trim($schema['description']));
        }
        if (array_key_exists('example', $schema)) {
            $doc[] = 'Exemple : '.json_encode($schema['example'], \JSON_UNESCAPED_UNICODE | \JSON_UNESCAPED_SLASHES);
        }
        if ([] !== $doc) {
            $doc[] = '';
        }
        if (null !== $type['doc']) {
            $doc[] = "@var {$type['doc']}";
            $paramDocs[] = "     * @param {$type['doc']} \${$property}";
        }
        // PHP 7.4 n'a pas de propriétés readonly : PHPStan vérifie @readonly à la place.
        $doc[] = '@readonly';

        $declarations[] = "    /**\n".implode('', array_map(static fn (string $line): string => '' === $line ? "     *\n" : "     * {$line}\n", $doc))."     */\n    public {$type['php']} \${$property};";
        $params[] = "        {$type['php']} \${$property}";
        $assignments[] = "        \$this->{$property} = \${$property};";
        $reads[] = "            {$type['read']},";
    }

    $marker = MARKER;
    $namespace = NAMESPACE_MODEL;
    $declarationsCode = implode("\n\n", $declarations);
    $constructorDoc = [] === $paramDocs ? '' : "    /**\n".implode("\n", $paramDocs)."\n     */\n";
    $paramsCode = implode(",\n", $params);
    $assignmentsCode = implode("\n", $assignments);
    $readsCode = implode("\n", $reads);
    $description = is_string($definition['description'] ?? null) ? ' * '.trim($definition['description'])."\n *\n" : '';

    return <<<PHP
        <?php

        declare(strict_types=1);

        namespace {$namespace};

        use EntreprisePage\\ApiClient\\Hydration\\Data;

        /**
        {$description} * {$marker} depuis api/docs/swagger.json, ne pas modifier à la main.
         */
        final class {$class}
        {
        {$declarationsCode}

        {$constructorDoc}    public function __construct(
        {$paramsCode}
            ) {
        {$assignmentsCode}
            }

            /**
             * @param array<mixed> \$data
             */
            public static function fromArray(array \$data): self
            {
                return new self(
        {$readsCode}
                );
            }
        }

        PHP;
}
