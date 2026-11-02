<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final class Coordonnees
{
    /**
     * Exemple : 45.7672724
     *
     * @readonly
     */
    public float $latitude;

    /**
     * Exemple : 4.8340594
     *
     * @readonly
     */
    public float $longitude;

    public function __construct(
        float $latitude,
        float $longitude
    ) {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Data::float($data, 'latitude'),
            Data::float($data, 'longitude'),
        );
    }
}
