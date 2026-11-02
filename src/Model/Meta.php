<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final class Meta
{
    /**
     * toto: ajouter l'annee de la categorie
     * Exemple : "PME"
     *
     * @readonly
     */
    public string $categorieEntreprise;

    /**
     * Exemple : true
     *
     * @readonly
     */
    public bool $estActif;

    /**
     * Exemple : true
     *
     * @readonly
     */
    public bool $estDiffusable;

    /**
     * Exemple : "google-france-443061841"
     *
     * @readonly
     */
    public string $slug;

    /**
     * todo: compter uniquement les actifs
     * Exemple : 15
     *
     * @readonly
     */
    public int $totalEtablissementActif;

    public function __construct(
        string $categorieEntreprise,
        bool $estActif,
        bool $estDiffusable,
        string $slug,
        int $totalEtablissementActif
    ) {
        $this->categorieEntreprise = $categorieEntreprise;
        $this->estActif = $estActif;
        $this->estDiffusable = $estDiffusable;
        $this->slug = $slug;
        $this->totalEtablissementActif = $totalEtablissementActif;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Data::string($data, 'categorie_entreprise'),
            Data::bool($data, 'est_actif'),
            Data::bool($data, 'est_diffusable'),
            Data::string($data, 'slug'),
            Data::int($data, 'total_etablissement_actif'),
        );
    }
}
