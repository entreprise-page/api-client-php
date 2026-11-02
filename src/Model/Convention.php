<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final class Convention
{
    /**
     * Exemple : 1486
     *
     * @readonly
     */
    public int $idcc;

    /**
     * Exemple : "Bureaux d'études techniques, des cabinets d'ingénieurs-conseils et des sociétés de conseils(BET, SYNTEC)"
     *
     * @readonly
     */
    public string $libelle;

    public function __construct(
        int $idcc,
        string $libelle
    ) {
        $this->idcc = $idcc;
        $this->libelle = $libelle;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Data::int($data, 'idcc'),
            Data::string($data, 'libelle'),
        );
    }
}
