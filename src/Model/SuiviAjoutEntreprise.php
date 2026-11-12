<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final class SuiviAjoutEntreprise
{
    /**
     * Exemple : "552032534"
     *
     * @readonly
     */
    public string $siren;

    public function __construct(
        string $siren
    ) {
        $this->siren = $siren;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Data::string($data, 'siren'),
        );
    }
}
