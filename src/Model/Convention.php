<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final readonly class Convention
{
    public function __construct(
        /**
         * Exemple : 1486
         */
        public int $idcc,
        /**
         * Exemple : "Bureaux d'études techniques, des cabinets d'ingénieurs-conseils et des sociétés de conseils(BET, SYNTEC)"
         */
        public string $libelle,
    ) {
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            idcc: Data::int($data, 'idcc'),
            libelle: Data::string($data, 'libelle'),
        );
    }
}
