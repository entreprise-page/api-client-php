<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final readonly class ActeAnnonce
{
    public function __construct(
        /**
         * Exemple : "Création d'un fonds de commerce"
         */
        public ?string $categorieCreation,
        /**
         * Exemple : "Immatriculation d'une société"
         */
        public ?string $categorieImmatriculation,
        /**
         * Exemple : "2020-06-15"
         */
        public ?string $dateCommencementActivite,
        /**
         * Exemple : "2020-06-01"
         */
        public ?string $dateImmatriculation,
        public ?string $descriptif,
        public ?VenteAnnonce $vente,
    ) {
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            categorieCreation: Data::nullableString($data, 'categorie_creation'),
            categorieImmatriculation: Data::nullableString($data, 'categorie_immatriculation'),
            dateCommencementActivite: Data::nullableString($data, 'date_commencement_activite'),
            dateImmatriculation: Data::nullableString($data, 'date_immatriculation'),
            descriptif: Data::nullableString($data, 'descriptif'),
            vente: Data::nullableObject($data, 'vente', VenteAnnonce::fromArray(...)),
        );
    }
}
