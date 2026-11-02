<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final class ModificationAnnonce
{
    /**
     * Exemple : "2020-06-15"
     *
     * @readonly
     */
    public ?string $dateCommencementActivite;

    /**
     * Exemple : "2020-06-20"
     *
     * @readonly
     */
    public ?string $dateEffet;

    /**
     * @readonly
     */
    public ?string $descriptif;

    public function __construct(
        ?string $dateCommencementActivite,
        ?string $dateEffet,
        ?string $descriptif
    ) {
        $this->dateCommencementActivite = $dateCommencementActivite;
        $this->dateEffet = $dateEffet;
        $this->descriptif = $descriptif;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Data::nullableString($data, 'date_commencement_activite'),
            Data::nullableString($data, 'date_effet'),
            Data::nullableString($data, 'descriptif'),
        );
    }
}
