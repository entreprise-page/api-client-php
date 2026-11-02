<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final class Adresse
{
    /**
     * Exemple : "75009"
     *
     * @readonly
     */
    public ?string $codePostal;

    /**
     * @readonly
     */
    public ?Commune $commune;

    /**
     * Exemple : "Batiment C"
     *
     * @readonly
     */
    public ?string $complement;

    /**
     * @readonly
     */
    public ?Coordonnees $coordonnees;

    /**
     * @readonly
     */
    public ?Departement $departement;

    /**
     * Exemple : "8 bis"
     *
     * @readonly
     */
    public ?string $numeroVoie;

    /**
     * @readonly
     */
    public Pays $pays;

    /**
     * @readonly
     */
    public ?Region $region;

    /**
     * Exemple : "rue DE LONDRES"
     *
     * @readonly
     */
    public ?string $typeEtNomVoie;

    public function __construct(
        ?string $codePostal,
        ?Commune $commune,
        ?string $complement,
        ?Coordonnees $coordonnees,
        ?Departement $departement,
        ?string $numeroVoie,
        Pays $pays,
        ?Region $region,
        ?string $typeEtNomVoie
    ) {
        $this->codePostal = $codePostal;
        $this->commune = $commune;
        $this->complement = $complement;
        $this->coordonnees = $coordonnees;
        $this->departement = $departement;
        $this->numeroVoie = $numeroVoie;
        $this->pays = $pays;
        $this->region = $region;
        $this->typeEtNomVoie = $typeEtNomVoie;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Data::nullableString($data, 'code_postal'),
            Data::nullableObject($data, 'commune', [Commune::class, 'fromArray']),
            Data::nullableString($data, 'complement'),
            Data::nullableObject($data, 'coordonnees', [Coordonnees::class, 'fromArray']),
            Data::nullableObject($data, 'departement', [Departement::class, 'fromArray']),
            Data::nullableString($data, 'numero_voie'),
            Data::object($data, 'pays', [Pays::class, 'fromArray']),
            Data::nullableObject($data, 'region', [Region::class, 'fromArray']),
            Data::nullableString($data, 'type_et_nom_voie'),
        );
    }
}
