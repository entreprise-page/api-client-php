<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final readonly class DepotAnnonce
{
    public function __construct(
        /**
         * Exemple : "2019-12-31"
         */
        public ?string $dateCloture,
        public ?string $descriptif,
        /**
         * Exemple : "Comptes annuels et rapports"
         */
        public ?string $typeDepot,
    ) {
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            dateCloture: Data::nullableString($data, 'date_cloture'),
            descriptif: Data::nullableString($data, 'descriptif'),
            typeDepot: Data::nullableString($data, 'type_depot'),
        );
    }
}
