<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final class RechercheActivite
{
    /**
     * @readonly
     */
    public int $page;

    /**
     * @readonly
     */
    public int $nombreParPage;

    /**
     * @readonly
     */
    public int $totalResultats;

    /**
     * @var list<ActiviteTrouvee>
     * @readonly
     */
    public array $resultats;

    /**
     * @param list<ActiviteTrouvee> $resultats
     */
    public function __construct(
        int $page,
        int $nombreParPage,
        int $totalResultats,
        array $resultats
    ) {
        $this->page = $page;
        $this->nombreParPage = $nombreParPage;
        $this->totalResultats = $totalResultats;
        $this->resultats = $resultats;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Data::int($data, 'page'),
            Data::int($data, 'nombre_par_page'),
            Data::int($data, 'total_resultats'),
            Data::objectList($data, 'resultats', [ActiviteTrouvee::class, 'fromArray']),
        );
    }
}
