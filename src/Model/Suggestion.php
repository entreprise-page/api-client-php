<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final class Suggestion
{
    /**
     * Exemple : "443061841"
     *
     * @readonly
     */
    public string $siren;

    /**
     * Exemple : "Google France"
     *
     * @readonly
     */
    public string $nom;

    /**
     * Exemple : "75009"
     *
     * @readonly
     */
    public string $localite;

    /**
     * Exemple : "Programmation, conseil et autres activités informatiques"
     *
     * @readonly
     */
    public string $activite;

    /**
     * Exemple : true
     *
     * @readonly
     */
    public bool $active;

    /**
     * Exemple : "google-france-443061841"
     *
     * @readonly
     */
    public string $slug;

    public function __construct(
        string $siren,
        string $nom,
        string $localite,
        string $activite,
        bool $active,
        string $slug
    ) {
        $this->siren = $siren;
        $this->nom = $nom;
        $this->localite = $localite;
        $this->activite = $activite;
        $this->active = $active;
        $this->slug = $slug;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Data::string($data, 'siren'),
            Data::string($data, 'nom'),
            Data::string($data, 'localite'),
            Data::string($data, 'activite'),
            Data::bool($data, 'active'),
            Data::string($data, 'slug'),
        );
    }
}
