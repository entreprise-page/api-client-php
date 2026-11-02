<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final class Etablissement
{
    /**
     * @readonly
     */
    public Activite $activitePrincipaleExercee;

    /**
     * @readonly
     */
    public Adresse $adresse;

    /**
     * @readonly
     */
    public ?Convention $conventionCollective;

    /**
     * Exemple : "FRGOOGLE"
     *
     * @readonly
     */
    public ?string $enseigne;

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
    public bool $estSiege;

    /**
     * Exemple : ["google.fr"]
     *
     * @var list<string>
     * @readonly
     */
    public array $nomsDeDomaine;

    /**
     * Exemple : "44306184100047"
     *
     * @readonly
     */
    public string $siret;

    /**
     * @param list<string> $nomsDeDomaine
     */
    public function __construct(
        Activite $activitePrincipaleExercee,
        Adresse $adresse,
        ?Convention $conventionCollective,
        ?string $enseigne,
        bool $estActif,
        bool $estSiege,
        array $nomsDeDomaine,
        string $siret
    ) {
        $this->activitePrincipaleExercee = $activitePrincipaleExercee;
        $this->adresse = $adresse;
        $this->conventionCollective = $conventionCollective;
        $this->enseigne = $enseigne;
        $this->estActif = $estActif;
        $this->estSiege = $estSiege;
        $this->nomsDeDomaine = $nomsDeDomaine;
        $this->siret = $siret;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Data::object($data, 'activite_principale_exercee', [Activite::class, 'fromArray']),
            Data::object($data, 'adresse', [Adresse::class, 'fromArray']),
            Data::nullableObject($data, 'convention_collective', [Convention::class, 'fromArray']),
            Data::nullableString($data, 'enseigne'),
            Data::bool($data, 'est_actif'),
            Data::bool($data, 'est_siege'),
            Data::stringList($data, 'noms_de_domaine'),
            Data::string($data, 'siret'),
        );
    }
}
