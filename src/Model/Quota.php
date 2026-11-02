<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final class Quota
{
    /**
     * @readonly
     */
    public int $max;

    /**
     * @readonly
     */
    public int $total;

    public function __construct(
        int $max,
        int $total
    ) {
        $this->max = $max;
        $this->total = $total;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Data::int($data, 'max'),
            Data::int($data, 'total'),
        );
    }
}
