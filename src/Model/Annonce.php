<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final class Annonce
{
    /**
     * Exemple : "A202001221441"
     *
     * @readonly
     */
    public string $id;

    /**
     * Exemple : "vente"
     *
     * @readonly
     */
    public string $famille;

    /**
     * Exemple : "annonce"
     *
     * @readonly
     */
    public string $typeAvis;

    /**
     * Exemple : "2020-06-28"
     *
     * @readonly
     */
    public ?string $dateParution;

    /**
     * @readonly
     */
    public ?ActeAnnonce $acte;

    /**
     * @readonly
     */
    public ?AvisPrecedentAnnonce $avisPrecedent;

    /**
     * @readonly
     */
    public ?DepotAnnonce $depot;

    /**
     * @readonly
     */
    public ?EtablissementAnnonce $etablissement;

    /**
     * @readonly
     */
    public ?JugementAnnonce $jugement;

    /**
     * @readonly
     */
    public ?ModificationAnnonce $modification;

    /**
     * Exemple : "75"
     *
     * @readonly
     */
    public ?string $numeroDepartement;

    /**
     * @readonly
     */
    public ParutionAnnonce $parution;

    /**
     * @var list<PersonneAnnonce>
     * @readonly
     */
    public array $personnes;

    /**
     * @var list<PersonneAnnonce>
     * @readonly
     */
    public array $precedentsExploitants;

    /**
     * @var list<PersonneAnnonce>
     * @readonly
     */
    public array $precedentsProprietaires;

    /**
     * @readonly
     */
    public ?RadiationAnnonce $radiation;

    /**
     * Exemple : "Paris"
     *
     * @readonly
     */
    public ?string $tribunal;

    /**
     * @param list<PersonneAnnonce> $personnes
     * @param list<PersonneAnnonce> $precedentsExploitants
     * @param list<PersonneAnnonce> $precedentsProprietaires
     */
    public function __construct(
        string $id,
        string $famille,
        string $typeAvis,
        ?string $dateParution,
        ?ActeAnnonce $acte,
        ?AvisPrecedentAnnonce $avisPrecedent,
        ?DepotAnnonce $depot,
        ?EtablissementAnnonce $etablissement,
        ?JugementAnnonce $jugement,
        ?ModificationAnnonce $modification,
        ?string $numeroDepartement,
        ParutionAnnonce $parution,
        array $personnes,
        array $precedentsExploitants,
        array $precedentsProprietaires,
        ?RadiationAnnonce $radiation,
        ?string $tribunal
    ) {
        $this->id = $id;
        $this->famille = $famille;
        $this->typeAvis = $typeAvis;
        $this->dateParution = $dateParution;
        $this->acte = $acte;
        $this->avisPrecedent = $avisPrecedent;
        $this->depot = $depot;
        $this->etablissement = $etablissement;
        $this->jugement = $jugement;
        $this->modification = $modification;
        $this->numeroDepartement = $numeroDepartement;
        $this->parution = $parution;
        $this->personnes = $personnes;
        $this->precedentsExploitants = $precedentsExploitants;
        $this->precedentsProprietaires = $precedentsProprietaires;
        $this->radiation = $radiation;
        $this->tribunal = $tribunal;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Data::string($data, 'id'),
            Data::string($data, 'famille'),
            Data::string($data, 'type_avis'),
            Data::nullableString($data, 'date_parution'),
            Data::nullableObject($data, 'acte', [ActeAnnonce::class, 'fromArray']),
            Data::nullableObject($data, 'avis_precedent', [AvisPrecedentAnnonce::class, 'fromArray']),
            Data::nullableObject($data, 'depot', [DepotAnnonce::class, 'fromArray']),
            Data::nullableObject($data, 'etablissement', [EtablissementAnnonce::class, 'fromArray']),
            Data::nullableObject($data, 'jugement', [JugementAnnonce::class, 'fromArray']),
            Data::nullableObject($data, 'modification', [ModificationAnnonce::class, 'fromArray']),
            Data::nullableString($data, 'numero_departement'),
            Data::object($data, 'parution', [ParutionAnnonce::class, 'fromArray']),
            Data::objectList($data, 'personnes', [PersonneAnnonce::class, 'fromArray']),
            Data::objectList($data, 'precedents_exploitants', [PersonneAnnonce::class, 'fromArray']),
            Data::objectList($data, 'precedents_proprietaires', [PersonneAnnonce::class, 'fromArray']),
            Data::nullableObject($data, 'radiation', [RadiationAnnonce::class, 'fromArray']),
            Data::nullableString($data, 'tribunal'),
        );
    }
}
