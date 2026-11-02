<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final class RadiationAnnonce
{
    /**
     * @readonly
     */
    public ?string $commentaire;

    /**
     * Exemple : "2020-05-31"
     *
     * @readonly
     */
    public ?string $dateCessationActivite;

    /**
     * Exemple : "2020-06-10"
     *
     * @readonly
     */
    public ?string $dateRadiation;

    public function __construct(
        ?string $commentaire,
        ?string $dateCessationActivite,
        ?string $dateRadiation
    ) {
        $this->commentaire = $commentaire;
        $this->dateCessationActivite = $dateCessationActivite;
        $this->dateRadiation = $dateRadiation;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Data::nullableString($data, 'commentaire'),
            Data::nullableString($data, 'date_cessation_activite'),
            Data::nullableString($data, 'date_radiation'),
        );
    }
}
