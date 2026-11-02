<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final class RechercheEntreprise
{
    /**
     * @readonly
     */
    public int $nombreParPage;

    /**
     * @readonly
     */
    public int $page;

    /**
     * @var list<ResultatRecherche>
     * @readonly
     */
    public array $resultats;

    /**
     * @readonly
     */
    public int $totalPages;

    /**
     * @readonly
     */
    public int $totalResultats;

    /**
     * @param list<ResultatRecherche> $resultats
     */
    public function __construct(
        int $nombreParPage,
        int $page,
        array $resultats,
        int $totalPages,
        int $totalResultats
    ) {
        $this->nombreParPage = $nombreParPage;
        $this->page = $page;
        $this->resultats = $resultats;
        $this->totalPages = $totalPages;
        $this->totalResultats = $totalResultats;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Data::int($data, 'nombre_par_page'),
            Data::int($data, 'page'),
            Data::objectList($data, 'resultats', [ResultatRecherche::class, 'fromArray']),
            Data::int($data, 'total_pages'),
            Data::int($data, 'total_resultats'),
        );
    }
}
