<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final readonly class Finance
{
    public function __construct(
        /**
         * Exemple : 2025
         */
        public int $annee,
        /**
         * Exemple : 568000
         */
        public float $chiffreAffaire,
        /**
         * Exemple : 268000
         */
        public float $margeBrut,
        /**
         * Exemple : 368000
         */
        public float $resultatNet,
    ) {
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            annee: Data::int($data, 'annee'),
            chiffreAffaire: Data::float($data, 'chiffre_affaire'),
            margeBrut: Data::float($data, 'marge_brut'),
            resultatNet: Data::float($data, 'resultat_net'),
        );
    }
}
