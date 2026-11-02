<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final readonly class RadiationAnnonce
{
    public function __construct(
        public ?string $commentaire,
        /**
         * Exemple : "2020-05-31"
         */
        public ?string $dateCessationActivite,
        /**
         * Exemple : "2020-06-10"
         */
        public ?string $dateRadiation,
    ) {
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            commentaire: Data::nullableString($data, 'commentaire'),
            dateCessationActivite: Data::nullableString($data, 'date_cessation_activite'),
            dateRadiation: Data::nullableString($data, 'date_radiation'),
        );
    }
}
