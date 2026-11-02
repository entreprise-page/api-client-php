<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final readonly class ActiviteTrouvee
{
    public function __construct(
        /**
         * Exemple : "43.22A"
         */
        public string $code,
        /**
         * Exemple : "Travaux d'installation d'eau et de gaz en tous locaux"
         */
        public ?string $libelle,
        /**
         * Exemple : "Construction"
         */
        public ?string $section,
        /**
         * Exemple : ["plombier","plomberie","dépannage plomberie"]
         * @var list<string>
         */
        public array $motsCles,
        /**
         * Exemple : 0.87
         */
        public ?float $pertinence,
    ) {
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            code: Data::string($data, 'code'),
            libelle: Data::nullableString($data, 'libelle'),
            section: Data::nullableString($data, 'section'),
            motsCles: Data::stringList($data, 'mots_cles'),
            pertinence: Data::nullableFloat($data, 'pertinence'),
        );
    }
}
