<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final class RegistreDateCessation
{
    /**
     * Exemple : "2002-08-14"
     *
     * @readonly
     */
    public ?string $dateCessation;

    /**
     * Exemple : "2002-08-14"
     *
     * @readonly
     */
    public ?string $dateCreation;

    /**
     * Exemple : "2002-08-14"
     *
     * @readonly
     */
    public ?string $dateMiseAJour;

    public function __construct(
        ?string $dateCessation,
        ?string $dateCreation,
        ?string $dateMiseAJour
    ) {
        $this->dateCessation = $dateCessation;
        $this->dateCreation = $dateCreation;
        $this->dateMiseAJour = $dateMiseAJour;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Data::nullableString($data, 'date_cessation'),
            Data::nullableString($data, 'date_creation'),
            Data::nullableString($data, 'date_mise_a_jour'),
        );
    }
}
