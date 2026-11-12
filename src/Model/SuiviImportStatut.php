<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final class SuiviImportStatut
{
    /**
     * Exemple : 1
     *
     * @readonly
     */
    public int $erreur;

    /**
     * Exemple : 2
     *
     * @readonly
     */
    public int $succes;

    /**
     * Exemple : 3
     *
     * @readonly
     */
    public int $total;

    public function __construct(
        int $erreur,
        int $succes,
        int $total
    ) {
        $this->erreur = $erreur;
        $this->succes = $succes;
        $this->total = $total;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Data::int($data, 'erreur'),
            Data::int($data, 'succes'),
            Data::int($data, 'total'),
        );
    }
}
