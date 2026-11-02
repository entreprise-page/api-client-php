<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final class AdresseAnnonce
{
    /**
     * Exemple : "BP 42"
     *
     * @readonly
     */
    public ?string $boitePostale;

    /**
     * Exemple : "75009"
     *
     * @readonly
     */
    public ?string $codePostal;

    /**
     * Exemple : "Batiment C"
     *
     * @readonly
     */
    public ?string $complement;

    /**
     * Exemple : "de Londres"
     *
     * @readonly
     */
    public ?string $nomVoie;

    /**
     * Exemple : "8 bis"
     *
     * @readonly
     */
    public ?string $numeroVoie;

    /**
     * Exemple : "France"
     *
     * @readonly
     */
    public ?string $pays;

    /**
     * Exemple : "rue"
     *
     * @readonly
     */
    public ?string $typeVoie;

    /**
     * Exemple : "Paris"
     *
     * @readonly
     */
    public ?string $ville;

    /**
     * Exemple : "8 bis rue de Londres"
     *
     * @readonly
     */
    public ?string $voie;

    public function __construct(
        ?string $boitePostale,
        ?string $codePostal,
        ?string $complement,
        ?string $nomVoie,
        ?string $numeroVoie,
        ?string $pays,
        ?string $typeVoie,
        ?string $ville,
        ?string $voie
    ) {
        $this->boitePostale = $boitePostale;
        $this->codePostal = $codePostal;
        $this->complement = $complement;
        $this->nomVoie = $nomVoie;
        $this->numeroVoie = $numeroVoie;
        $this->pays = $pays;
        $this->typeVoie = $typeVoie;
        $this->ville = $ville;
        $this->voie = $voie;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Data::nullableString($data, 'boite_postale'),
            Data::nullableString($data, 'code_postal'),
            Data::nullableString($data, 'complement'),
            Data::nullableString($data, 'nom_voie'),
            Data::nullableString($data, 'numero_voie'),
            Data::nullableString($data, 'pays'),
            Data::nullableString($data, 'type_voie'),
            Data::nullableString($data, 'ville'),
            Data::nullableString($data, 'voie'),
        );
    }
}
