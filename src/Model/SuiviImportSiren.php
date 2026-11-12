<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final class SuiviImportSiren
{
    /**
     * Exemple : "552032534,542051180"
     *
     * @readonly
     */
    public string $sirens;

    public function __construct(
        string $sirens
    ) {
        $this->sirens = $sirens;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Data::string($data, 'sirens'),
        );
    }
}
