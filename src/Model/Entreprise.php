<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final class Entreprise
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
    public ?string $denominationSociale;

    /**
     * @readonly
     */
    public Activite $activitePrincipaleExercee;

    /**
     * Exemple : 1000000
     *
     * @readonly
     */
    public ?float $capitalSocial;

    /**
     * @var list<Convention>
     * @readonly
     */
    public array $conventions;

    /**
     * Exemple : "2006-02-08"
     *
     * @readonly
     */
    public ?string $dateCessation;

    /**
     * Exemple : "2002-05-16"
     *
     * @readonly
     */
    public ?string $dateCreation;

    /**
     * @readonly
     */
    public Dirigeant $dirigeant;

    /**
     * @readonly
     */
    public Effectif $effectif;

    /**
     * @var list<Finance>
     * @readonly
     */
    public array $finances;

    /**
     * @readonly
     */
    public FormeJuridique $formeJuridique;

    /**
     * Exemple : "Paris"
     *
     * @readonly
     */
    public ?string $greffe;

    /**
     * Exemple : "W751017910"
     *
     * @readonly
     */
    public ?string $identifiantAssociation;

    /**
     * @readonly
     */
    public Meta $meta;

    /**
     * Exemple : "FR64443061841"
     *
     * @readonly
     */
    public string $numeroTva;

    /**
     * @readonly
     */
    public Registre $registre;

    /**
     * @readonly
     */
    public ?Etablissement $siegeSocial;

    /**
     * @param list<Convention> $conventions
     * @param list<Finance> $finances
     */
    public function __construct(
        string $siren,
        ?string $denominationSociale,
        Activite $activitePrincipaleExercee,
        ?float $capitalSocial,
        array $conventions,
        ?string $dateCessation,
        ?string $dateCreation,
        Dirigeant $dirigeant,
        Effectif $effectif,
        array $finances,
        FormeJuridique $formeJuridique,
        ?string $greffe,
        ?string $identifiantAssociation,
        Meta $meta,
        string $numeroTva,
        Registre $registre,
        ?Etablissement $siegeSocial
    ) {
        $this->siren = $siren;
        $this->denominationSociale = $denominationSociale;
        $this->activitePrincipaleExercee = $activitePrincipaleExercee;
        $this->capitalSocial = $capitalSocial;
        $this->conventions = $conventions;
        $this->dateCessation = $dateCessation;
        $this->dateCreation = $dateCreation;
        $this->dirigeant = $dirigeant;
        $this->effectif = $effectif;
        $this->finances = $finances;
        $this->formeJuridique = $formeJuridique;
        $this->greffe = $greffe;
        $this->identifiantAssociation = $identifiantAssociation;
        $this->meta = $meta;
        $this->numeroTva = $numeroTva;
        $this->registre = $registre;
        $this->siegeSocial = $siegeSocial;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Data::string($data, 'siren'),
            Data::nullableString($data, 'denomination_sociale'),
            Data::object($data, 'activite_principale_exercee', [Activite::class, 'fromArray']),
            Data::nullableFloat($data, 'capital_social'),
            Data::objectList($data, 'conventions', [Convention::class, 'fromArray']),
            Data::nullableString($data, 'date_cessation'),
            Data::nullableString($data, 'date_creation'),
            Data::object($data, 'dirigeant', [Dirigeant::class, 'fromArray']),
            Data::object($data, 'effectif', [Effectif::class, 'fromArray']),
            Data::objectList($data, 'finances', [Finance::class, 'fromArray']),
            Data::object($data, 'forme_juridique', [FormeJuridique::class, 'fromArray']),
            Data::nullableString($data, 'greffe'),
            Data::nullableString($data, 'identifiant_association'),
            Data::object($data, 'meta', [Meta::class, 'fromArray']),
            Data::string($data, 'numero_tva'),
            Data::object($data, 'registre', [Registre::class, 'fromArray']),
            Data::nullableObject($data, 'siege_social', [Etablissement::class, 'fromArray']),
        );
    }
}
