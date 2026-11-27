<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final class SuiviStatut
{
    /**
     * Exemple : "cessee"
     *
     * @readonly
     */
    public string $code;

    /**
     * Exemple : "2024-12-31"
     *
     * @readonly
     */
    public ?string $date;

    public function __construct(
        string $code,
        ?string $date
    ) {
        $this->code = $code;
        $this->date = $date;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Data::string($data, 'code'),
            Data::nullableString($data, 'date'),
        );
    }
}
