<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final readonly class Adresse
{
    public function __construct(
        /**
         * Exemple : "75009"
         */
        public ?string $codePostal,
        public ?Commune $commune,
        /**
         * Exemple : "Batiment C"
         */
        public ?string $complement,
        public ?Coordonnees $coordonnees,
        public ?Departement $departement,
        /**
         * Exemple : "8 bis"
         */
        public ?string $numeroVoie,
        public Pays $pays,
        public ?Region $region,
        /**
         * Exemple : "rue DE LONDRES"
         */
        public ?string $typeEtNomVoie,
    ) {
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            codePostal: Data::nullableString($data, 'code_postal'),
            commune: Data::nullableObject($data, 'commune', Commune::fromArray(...)),
            complement: Data::nullableString($data, 'complement'),
            coordonnees: Data::nullableObject($data, 'coordonnees', Coordonnees::fromArray(...)),
            departement: Data::nullableObject($data, 'departement', Departement::fromArray(...)),
            numeroVoie: Data::nullableString($data, 'numero_voie'),
            pays: Data::object($data, 'pays', Pays::fromArray(...)),
            region: Data::nullableObject($data, 'region', Region::fromArray(...)),
            typeEtNomVoie: Data::nullableString($data, 'type_et_nom_voie'),
        );
    }
}
