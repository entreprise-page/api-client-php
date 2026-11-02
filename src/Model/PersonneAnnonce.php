<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final class PersonneAnnonce
{
    /**
     * Exemple : "restauration rapide"
     *
     * @readonly
     */
    public ?string $activite;

    /**
     * Exemple : "Gérant : Jean Dupont"
     *
     * @readonly
     */
    public ?string $administration;

    /**
     * @readonly
     */
    public ?AdresseAnnonce $adresse;

    /**
     * @readonly
     */
    public ?CapitalAnnonce $capital;

    /**
     * Exemple : "Google France"
     *
     * @readonly
     */
    public ?string $denomination;

    /**
     * Exemple : false
     *
     * @readonly
     */
    public bool $estNonInscrit;

    /**
     * Exemple : "Société par actions simplifiée"
     *
     * @readonly
     */
    public ?string $formeJuridique;

    /**
     * Exemple : "Paris"
     *
     * @readonly
     */
    public ?string $greffe;

    /**
     * Exemple : "Google France"
     *
     * @readonly
     */
    public string $libelle;

    /**
     * Exemple : "Dupont"
     *
     * @readonly
     */
    public ?string $nom;

    /**
     * Exemple : "Chez Jean"
     *
     * @readonly
     */
    public ?string $nomCommercial;

    /**
     * Exemple : "Durand"
     *
     * @readonly
     */
    public ?string $nomUsage;

    /**
     * Exemple : "Jean"
     *
     * @readonly
     */
    public ?string $prenom;

    /**
     * Exemple : "GF"
     *
     * @readonly
     */
    public ?string $sigle;

    /**
     * Exemple : "443061841"
     *
     * @readonly
     */
    public ?string $siren;

    /**
     * Exemple : "pm"
     *
     * @readonly
     */
    public string $typePersonne;

    public function __construct(
        ?string $activite,
        ?string $administration,
        ?AdresseAnnonce $adresse,
        ?CapitalAnnonce $capital,
        ?string $denomination,
        bool $estNonInscrit,
        ?string $formeJuridique,
        ?string $greffe,
        string $libelle,
        ?string $nom,
        ?string $nomCommercial,
        ?string $nomUsage,
        ?string $prenom,
        ?string $sigle,
        ?string $siren,
        string $typePersonne
    ) {
        $this->activite = $activite;
        $this->administration = $administration;
        $this->adresse = $adresse;
        $this->capital = $capital;
        $this->denomination = $denomination;
        $this->estNonInscrit = $estNonInscrit;
        $this->formeJuridique = $formeJuridique;
        $this->greffe = $greffe;
        $this->libelle = $libelle;
        $this->nom = $nom;
        $this->nomCommercial = $nomCommercial;
        $this->nomUsage = $nomUsage;
        $this->prenom = $prenom;
        $this->sigle = $sigle;
        $this->siren = $siren;
        $this->typePersonne = $typePersonne;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Data::nullableString($data, 'activite'),
            Data::nullableString($data, 'administration'),
            Data::nullableObject($data, 'adresse', [AdresseAnnonce::class, 'fromArray']),
            Data::nullableObject($data, 'capital', [CapitalAnnonce::class, 'fromArray']),
            Data::nullableString($data, 'denomination'),
            Data::bool($data, 'est_non_inscrit'),
            Data::nullableString($data, 'forme_juridique'),
            Data::nullableString($data, 'greffe'),
            Data::string($data, 'libelle'),
            Data::nullableString($data, 'nom'),
            Data::nullableString($data, 'nom_commercial'),
            Data::nullableString($data, 'nom_usage'),
            Data::nullableString($data, 'prenom'),
            Data::nullableString($data, 'sigle'),
            Data::nullableString($data, 'siren'),
            Data::string($data, 'type_personne'),
        );
    }
}
