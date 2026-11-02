<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final readonly class RechercheEntreprise
{
    public function __construct(
        public int $nombreParPage,
        public int $page,
        /**
         * @var list<ResultatRecherche>
         */
        public array $resultats,
        public int $totalPages,
        public int $totalResultats,
    ) {
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            nombreParPage: Data::int($data, 'nombre_par_page'),
            page: Data::int($data, 'page'),
            resultats: Data::objectList($data, 'resultats', ResultatRecherche::fromArray(...)),
            totalPages: Data::int($data, 'total_pages'),
            totalResultats: Data::int($data, 'total_resultats'),
        );
    }
}
