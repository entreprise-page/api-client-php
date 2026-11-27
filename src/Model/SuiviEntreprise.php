<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final class SuiviEntreprise
{
    /**
     * Exemple : "70.10Z"
     *
     * @readonly
     */
    public string $activiteCode;

    /**
     * Exemple : "Activités des sièges sociaux"
     *
     * @readonly
     */
    public ?string $activiteLibelle;

    /**
     * Exemple : "17 boulevard HAUSSMANN 75009 Paris"
     *
     * @readonly
     */
    public string $adresse;

    /**
     * Exemple : "1955-01-01"
     *
     * @readonly
     */
    public ?string $dateEnActivite;

    /**
     * DateEnCessation est la date du statut quand l'entreprise n'est plus active.
     * Exemple : "2024-12-31"
     *
     * @readonly
     */
    public ?string $dateEnCessation;

    /**
     * Exemple : "DANONE"
     *
     * @readonly
     */
    public ?string $denomination;

    /**
     * Exemple : true
     *
     * @readonly
     */
    public bool $estActive;

    /**
     * Exemple : true
     *
     * @readonly
     */
    public bool $estDiffusable;

    /**
     * Exemple : "552032534"
     *
     * @readonly
     */
    public string $siren;

    /**
     * Exemple : "danone-552032534"
     *
     * @readonly
     */
    public string $slug;

    /**
     * @readonly
     */
    public SuiviStatut $statut;

    public function __construct(
        string $activiteCode,
        ?string $activiteLibelle,
        string $adresse,
        ?string $dateEnActivite,
        ?string $dateEnCessation,
        ?string $denomination,
        bool $estActive,
        bool $estDiffusable,
        string $siren,
        string $slug,
        SuiviStatut $statut
    ) {
        $this->activiteCode = $activiteCode;
        $this->activiteLibelle = $activiteLibelle;
        $this->adresse = $adresse;
        $this->dateEnActivite = $dateEnActivite;
        $this->dateEnCessation = $dateEnCessation;
        $this->denomination = $denomination;
        $this->estActive = $estActive;
        $this->estDiffusable = $estDiffusable;
        $this->siren = $siren;
        $this->slug = $slug;
        $this->statut = $statut;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Data::string($data, 'activite_code'),
            Data::nullableString($data, 'activite_libelle'),
            Data::string($data, 'adresse'),
            Data::nullableString($data, 'date_en_activite'),
            Data::nullableString($data, 'date_en_cessation'),
            Data::nullableString($data, 'denomination'),
            Data::bool($data, 'est_active'),
            Data::bool($data, 'est_diffusable'),
            Data::string($data, 'siren'),
            Data::string($data, 'slug'),
            Data::object($data, 'statut', [SuiviStatut::class, 'fromArray']),
        );
    }
}
