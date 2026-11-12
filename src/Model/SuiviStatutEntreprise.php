<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final class SuiviStatutEntreprise
{
    /**
     * Exemple : true
     *
     * @readonly
     */
    public bool $estSuivie;

    public function __construct(
        bool $estSuivie
    ) {
        $this->estSuivie = $estSuivie;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Data::bool($data, 'est_suivie'),
        );
    }
}
