<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final readonly class EtablissementAnnonce
{
    public function __construct(
        /**
         * Exemple : "restauration rapide"
         */
        public ?string $activite,
        public ?AdresseAnnonce $adresse,
        /**
         * Exemple : "Chez Jean"
         */
        public ?string $enseigne,
        /**
         * Exemple : "Création"
         */
        public ?string $origineFonds,
        /**
         * Exemple : "Etablissement principal"
         */
        public ?string $qualite,
    ) {
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            activite: Data::nullableString($data, 'activite'),
            adresse: Data::nullableObject($data, 'adresse', AdresseAnnonce::fromArray(...)),
            enseigne: Data::nullableString($data, 'enseigne'),
            origineFonds: Data::nullableString($data, 'origine_fonds'),
            qualite: Data::nullableString($data, 'qualite'),
        );
    }
}
