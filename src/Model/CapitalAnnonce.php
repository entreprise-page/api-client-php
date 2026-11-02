<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final readonly class CapitalAnnonce
{
    public function __construct(
        /**
         * Exemple : "EUR"
         */
        public string $devise,
        /**
         * Exemple : false
         */
        public bool $estVariable,
        /**
         * Exemple : 10000
         */
        public float $montant,
    ) {
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            devise: Data::string($data, 'devise'),
            estVariable: Data::bool($data, 'est_variable'),
            montant: Data::float($data, 'montant'),
        );
    }
}
