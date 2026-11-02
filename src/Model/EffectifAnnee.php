<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final class EffectifAnnee
{
    /**
     * Exemple : 2025
     *
     * @readonly
     */
    public int $annee;

    /**
     * Exemple : 42
     *
     * @readonly
     */
    public int $code;

    /**
     * Exemple : 1999
     *
     * @readonly
     */
    public int $max;

    /**
     * Exemple : 1000
     *
     * @readonly
     */
    public int $min;

    public function __construct(
        int $annee,
        int $code,
        int $max,
        int $min
    ) {
        $this->annee = $annee;
        $this->code = $code;
        $this->max = $max;
        $this->min = $min;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Data::int($data, 'annee'),
            Data::int($data, 'code'),
            Data::int($data, 'max'),
            Data::int($data, 'min'),
        );
    }
}
