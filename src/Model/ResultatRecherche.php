<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final readonly class ResultatRecherche
{
    public function __construct(
        /**
         * Exemple : "443061841"
         */
        public string $siren,
        /**
         * Exemple : "Google France"
         */
        public ?string $denominationSociale,
        public Activite $activitePrincipaleExercee,
        /**
         * Exemple : 1000000
         */
        public ?float $capitalSocial,
        /**
         * @var list<Convention>
         */
        public array $conventions,
        /**
         * Exemple : "2006-02-08"
         */
        public ?string $dateCessation,
        /**
         * Exemple : "2002-05-16"
         */
        public ?string $dateCreation,
        public Dirigeant $dirigeant,
        /**
         * Distance en mètres entre le point de recherche et l'établissement le plus proche, absente hors recherche géographique.
         * Exemple : 4200
         */
        public ?int $distanceMetres,
        public Effectif $effectif,
        /**
         * Établissement actif le plus proche du point de recherche, celui qui a fait ressortir l'entreprise : ce n'est pas forcément le siège social.
         */
        public ?Etablissement $etablissementLePlusProche,
        /**
         * @var list<Finance>
         */
        public array $finances,
        public FormeJuridique $formeJuridique,
        /**
         * Exemple : "Paris"
         */
        public ?string $greffe,
        /**
         * Exemple : "W751017910"
         */
        public ?string $identifiantAssociation,
        public Meta $meta,
        /**
         * Exemple : "FR64443061841"
         */
        public string $numeroTva,
        public Registre $registre,
        public ?Etablissement $siegeSocial,
    ) {
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            siren: Data::string($data, 'siren'),
            denominationSociale: Data::nullableString($data, 'denomination_sociale'),
            activitePrincipaleExercee: Data::object($data, 'activite_principale_exercee', Activite::fromArray(...)),
            capitalSocial: Data::nullableFloat($data, 'capital_social'),
            conventions: Data::objectList($data, 'conventions', Convention::fromArray(...)),
            dateCessation: Data::nullableString($data, 'date_cessation'),
            dateCreation: Data::nullableString($data, 'date_creation'),
            dirigeant: Data::object($data, 'dirigeant', Dirigeant::fromArray(...)),
            distanceMetres: Data::nullableInt($data, 'distance_metres'),
            effectif: Data::object($data, 'effectif', Effectif::fromArray(...)),
            etablissementLePlusProche: Data::nullableObject($data, 'etablissement_le_plus_proche', Etablissement::fromArray(...)),
            finances: Data::objectList($data, 'finances', Finance::fromArray(...)),
            formeJuridique: Data::object($data, 'forme_juridique', FormeJuridique::fromArray(...)),
            greffe: Data::nullableString($data, 'greffe'),
            identifiantAssociation: Data::nullableString($data, 'identifiant_association'),
            meta: Data::object($data, 'meta', Meta::fromArray(...)),
            numeroTva: Data::string($data, 'numero_tva'),
            registre: Data::object($data, 'registre', Registre::fromArray(...)),
            siegeSocial: Data::nullableObject($data, 'siege_social', Etablissement::fromArray(...)),
        );
    }
}
