<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Hydration;

use EntreprisePage\ApiClient\Exception\UnexpectedResponseException;

/**
 * Lecture typée des réponses JSON décodées, utilisée par les modèles générés.
 *
 * Un champ non nullable absent ou mal typé lève une exception : cela signale
 * une dérive entre le SDK et l'API plutôt que de la masquer. Les listes `null`
 * (slices nil côté Go) sont lues comme des listes vides.
 *
 * @internal
 */
final class Data
{
    /**
     * @param array<mixed> $data
     */
    public static function string(array $data, string $key): string
    {
        $value = $data[$key] ?? null;

        return \is_string($value) ? $value : throw self::invalid($key, 'string', $value);
    }

    /**
     * @param array<mixed> $data
     */
    public static function nullableString(array $data, string $key): ?string
    {
        return null === ($data[$key] ?? null) ? null : self::string($data, $key);
    }

    /**
     * @param array<mixed> $data
     */
    public static function int(array $data, string $key): int
    {
        $value = $data[$key] ?? null;

        return \is_int($value) ? $value : throw self::invalid($key, 'int', $value);
    }

    /**
     * @param array<mixed> $data
     */
    public static function nullableInt(array $data, string $key): ?int
    {
        return null === ($data[$key] ?? null) ? null : self::int($data, $key);
    }

    /**
     * @param array<mixed> $data
     */
    public static function float(array $data, string $key): float
    {
        $value = $data[$key] ?? null;

        return \is_int($value) || \is_float($value) ? (float) $value : throw self::invalid($key, 'float', $value);
    }

    /**
     * @param array<mixed> $data
     */
    public static function nullableFloat(array $data, string $key): ?float
    {
        return null === ($data[$key] ?? null) ? null : self::float($data, $key);
    }

    /**
     * @param array<mixed> $data
     */
    public static function bool(array $data, string $key): bool
    {
        $value = $data[$key] ?? null;

        return \is_bool($value) ? $value : throw self::invalid($key, 'bool', $value);
    }

    /**
     * @param array<mixed> $data
     */
    public static function nullableBool(array $data, string $key): ?bool
    {
        return null === ($data[$key] ?? null) ? null : self::bool($data, $key);
    }

    /**
     * @template T of object
     *
     * @param array<mixed>               $data
     * @param callable(array<mixed>): T $factory
     *
     * @return T
     */
    public static function object(array $data, string $key, callable $factory): object
    {
        $value = $data[$key] ?? null;

        return \is_array($value) ? $factory($value) : throw self::invalid($key, 'object', $value);
    }

    /**
     * @template T of object
     *
     * @param array<mixed>               $data
     * @param callable(array<mixed>): T $factory
     *
     * @return T|null
     */
    public static function nullableObject(array $data, string $key, callable $factory): ?object
    {
        return null === ($data[$key] ?? null) ? null : self::object($data, $key, $factory);
    }

    /**
     * @template T of object
     *
     * @param array<mixed>               $data
     * @param callable(array<mixed>): T $factory
     *
     * @return list<T>
     */
    public static function objectList(array $data, string $key, callable $factory): array
    {
        return array_map(
            static fn (mixed $item): object => \is_array($item) ? $factory($item) : throw self::invalid($key.'[]', 'object', $item),
            self::list($data, $key),
        );
    }

    /**
     * @param array<mixed> $data
     *
     * @return list<string>
     */
    public static function stringList(array $data, string $key): array
    {
        return array_map(
            static fn (mixed $item): string => \is_string($item) ? $item : throw self::invalid($key.'[]', 'string', $item),
            self::list($data, $key),
        );
    }

    /**
     * Décode un corps de réponse JSON en tableau, objet ou liste.
     *
     * @return array<mixed>
     */
    public static function decode(string $json): array
    {
        try {
            $decoded = json_decode($json, true, 512, \JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw new UnexpectedResponseException('La réponse de l\'API n\'est pas un JSON valide : '.$e->getMessage(), 0, $e);
        }

        return \is_array($decoded) ? $decoded : throw self::invalid('(racine)', 'object ou liste', $decoded);
    }

    /**
     * Applique une fabrique à chaque élément d'une liste JSON racine.
     *
     * @template T of object
     *
     * @param array<mixed>               $items
     * @param callable(array<mixed>): T $factory
     *
     * @return list<T>
     */
    public static function mapList(array $items, callable $factory): array
    {
        return self::objectList(['(racine)' => $items], '(racine)', $factory);
    }

    /**
     * @param array<mixed> $data
     *
     * @return list<mixed>
     */
    private static function list(array $data, string $key): array
    {
        $value = $data[$key] ?? [];

        return \is_array($value) && array_is_list($value) ? $value : throw self::invalid($key, 'list', $value);
    }

    private static function invalid(string $key, string $expected, mixed $value): UnexpectedResponseException
    {
        return new UnexpectedResponseException(\sprintf(
            'Le champ "%s" devrait être de type %s, %s reçu.',
            $key,
            $expected,
            get_debug_type($value),
        ));
    }
}
