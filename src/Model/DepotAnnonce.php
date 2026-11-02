<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final class DepotAnnonce
{
    /**
     * Exemple : "2019-12-31"
     *
     * @readonly
     */
    public ?string $dateCloture;

    /**
     * @readonly
     */
    public ?string $descriptif;

    /**
     * Exemple : "Comptes annuels et rapports"
     *
     * @readonly
     */
    public ?string $typeDepot;

    public function __construct(
        ?string $dateCloture,
        ?string $descriptif,
        ?string $typeDepot
    ) {
        $this->dateCloture = $dateCloture;
        $this->descriptif = $descriptif;
        $this->typeDepot = $typeDepot;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Data::nullableString($data, 'date_cloture'),
            Data::nullableString($data, 'descriptif'),
            Data::nullableString($data, 'type_depot'),
        );
    }
}
