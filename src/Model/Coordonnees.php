<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final readonly class Coordonnees
{
    public function __construct(
        /**
         * Exemple : 45.7672724
         */
        public float $latitude,
        /**
         * Exemple : 4.8340594
         */
        public float $longitude,
    ) {
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            latitude: Data::float($data, 'latitude'),
            longitude: Data::float($data, 'longitude'),
        );
    }
}
