<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final class SuiviPagination
{
    /**
     * Exemple : 10
     *
     * @readonly
     */
    public int $nombreResultat;

    /**
     * Exemple : 10
     *
     * @readonly
     */
    public int $nombreResultatParPage;

    /**
     * Exemple : 1
     *
     * @readonly
     */
    public int $pageEnCours;

    /**
     * Exemple : 3
     *
     * @readonly
     */
    public int $totalPage;

    /**
     * Exemple : 25
     *
     * @readonly
     */
    public int $totalResultat;

    public function __construct(
        int $nombreResultat,
        int $nombreResultatParPage,
        int $pageEnCours,
        int $totalPage,
        int $totalResultat
    ) {
        $this->nombreResultat = $nombreResultat;
        $this->nombreResultatParPage = $nombreResultatParPage;
        $this->pageEnCours = $pageEnCours;
        $this->totalPage = $totalPage;
        $this->totalResultat = $totalResultat;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Data::int($data, 'nombre_resultat'),
            Data::int($data, 'nombre_resultat_par_page'),
            Data::int($data, 'page_en_cours'),
            Data::int($data, 'total_page'),
            Data::int($data, 'total_resultat'),
        );
    }
}
