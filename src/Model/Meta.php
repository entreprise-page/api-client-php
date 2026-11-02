<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final readonly class Meta
{
    public function __construct(
        /**
         * toto: ajouter l'annee de la categorie
         * Exemple : "PME"
         */
        public string $categorieEntreprise,
        /**
         * Exemple : true
         */
        public bool $estActif,
        /**
         * Exemple : true
         */
        public bool $estDiffusable,
        /**
         * Exemple : "google-france-443061841"
         */
        public string $slug,
        /**
         * todo: compter uniquement les actifs
         * Exemple : 15
         */
        public int $totalEtablissementActif,
    ) {
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            categorieEntreprise: Data::string($data, 'categorie_entreprise'),
            estActif: Data::bool($data, 'est_actif'),
            estDiffusable: Data::bool($data, 'est_diffusable'),
            slug: Data::string($data, 'slug'),
            totalEtablissementActif: Data::int($data, 'total_etablissement_actif'),
        );
    }
}
