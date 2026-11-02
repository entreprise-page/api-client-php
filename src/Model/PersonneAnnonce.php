<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final readonly class PersonneAnnonce
{
    public function __construct(
        /**
         * Exemple : "restauration rapide"
         */
        public ?string $activite,
        /**
         * Exemple : "Gérant : Jean Dupont"
         */
        public ?string $administration,
        public ?AdresseAnnonce $adresse,
        public ?CapitalAnnonce $capital,
        /**
         * Exemple : "Google France"
         */
        public ?string $denomination,
        /**
         * Exemple : false
         */
        public bool $estNonInscrit,
        /**
         * Exemple : "Société par actions simplifiée"
         */
        public ?string $formeJuridique,
        /**
         * Exemple : "Paris"
         */
        public ?string $greffe,
        /**
         * Exemple : "Google France"
         */
        public string $libelle,
        /**
         * Exemple : "Dupont"
         */
        public ?string $nom,
        /**
         * Exemple : "Chez Jean"
         */
        public ?string $nomCommercial,
        /**
         * Exemple : "Durand"
         */
        public ?string $nomUsage,
        /**
         * Exemple : "Jean"
         */
        public ?string $prenom,
        /**
         * Exemple : "GF"
         */
        public ?string $sigle,
        /**
         * Exemple : "443061841"
         */
        public ?string $siren,
        /**
         * Exemple : "pm"
         */
        public string $typePersonne,
    ) {
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            activite: Data::nullableString($data, 'activite'),
            administration: Data::nullableString($data, 'administration'),
            adresse: Data::nullableObject($data, 'adresse', AdresseAnnonce::fromArray(...)),
            capital: Data::nullableObject($data, 'capital', CapitalAnnonce::fromArray(...)),
            denomination: Data::nullableString($data, 'denomination'),
            estNonInscrit: Data::bool($data, 'est_non_inscrit'),
            formeJuridique: Data::nullableString($data, 'forme_juridique'),
            greffe: Data::nullableString($data, 'greffe'),
            libelle: Data::string($data, 'libelle'),
            nom: Data::nullableString($data, 'nom'),
            nomCommercial: Data::nullableString($data, 'nom_commercial'),
            nomUsage: Data::nullableString($data, 'nom_usage'),
            prenom: Data::nullableString($data, 'prenom'),
            sigle: Data::nullableString($data, 'sigle'),
            siren: Data::nullableString($data, 'siren'),
            typePersonne: Data::string($data, 'type_personne'),
        );
    }
}
