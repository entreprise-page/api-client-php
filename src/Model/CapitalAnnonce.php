<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final class CapitalAnnonce
{
    /**
     * Exemple : "EUR"
     *
     * @readonly
     */
    public string $devise;

    /**
     * Exemple : false
     *
     * @readonly
     */
    public bool $estVariable;

    /**
     * Exemple : 10000
     *
     * @readonly
     */
    public float $montant;

    public function __construct(
        string $devise,
        bool $estVariable,
        float $montant
    ) {
        $this->devise = $devise;
        $this->estVariable = $estVariable;
        $this->montant = $montant;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Data::string($data, 'devise'),
            Data::bool($data, 'est_variable'),
            Data::float($data, 'montant'),
        );
    }
}
