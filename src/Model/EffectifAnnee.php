<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final readonly class EffectifAnnee
{
    public function __construct(
        /**
         * Exemple : 2025
         */
        public int $annee,
        /**
         * Exemple : 42
         */
        public int $code,
        /**
         * Exemple : 1999
         */
        public int $max,
        /**
         * Exemple : 1000
         */
        public int $min,
    ) {
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            annee: Data::int($data, 'annee'),
            code: Data::int($data, 'code'),
            max: Data::int($data, 'max'),
            min: Data::int($data, 'min'),
        );
    }
}
