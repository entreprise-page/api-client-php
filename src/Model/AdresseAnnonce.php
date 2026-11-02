<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final readonly class AdresseAnnonce
{
    public function __construct(
        /**
         * Exemple : "BP 42"
         */
        public ?string $boitePostale,
        /**
         * Exemple : "75009"
         */
        public ?string $codePostal,
        /**
         * Exemple : "Batiment C"
         */
        public ?string $complement,
        /**
         * Exemple : "de Londres"
         */
        public ?string $nomVoie,
        /**
         * Exemple : "8 bis"
         */
        public ?string $numeroVoie,
        /**
         * Exemple : "France"
         */
        public ?string $pays,
        /**
         * Exemple : "rue"
         */
        public ?string $typeVoie,
        /**
         * Exemple : "Paris"
         */
        public ?string $ville,
        /**
         * Exemple : "8 bis rue de Londres"
         */
        public ?string $voie,
    ) {
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            boitePostale: Data::nullableString($data, 'boite_postale'),
            codePostal: Data::nullableString($data, 'code_postal'),
            complement: Data::nullableString($data, 'complement'),
            nomVoie: Data::nullableString($data, 'nom_voie'),
            numeroVoie: Data::nullableString($data, 'numero_voie'),
            pays: Data::nullableString($data, 'pays'),
            typeVoie: Data::nullableString($data, 'type_voie'),
            ville: Data::nullableString($data, 'ville'),
            voie: Data::nullableString($data, 'voie'),
        );
    }
}
