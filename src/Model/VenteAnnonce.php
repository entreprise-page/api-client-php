<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final readonly class VenteAnnonce
{
    public function __construct(
        /**
         * Exemple : "Vente"
         */
        public ?string $categorie,
        /**
         * Exemple : "2020-06-20"
         */
        public ?string $dateEffet,
        /**
         * Exemple : "2020-06-22"
         */
        public ?string $datePublicite,
        /**
         * @var list<string>
         */
        public array $oppositions,
        public ?string $publiciteLegale,
    ) {
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            categorie: Data::nullableString($data, 'categorie'),
            dateEffet: Data::nullableString($data, 'date_effet'),
            datePublicite: Data::nullableString($data, 'date_publicite'),
            oppositions: Data::stringList($data, 'oppositions'),
            publiciteLegale: Data::nullableString($data, 'publicite_legale'),
        );
    }
}
