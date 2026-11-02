<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final readonly class RechercheActivite
{
    public function __construct(
        public int $page,
        public int $nombreParPage,
        public int $totalResultats,
        /**
         * @var list<ActiviteTrouvee>
         */
        public array $resultats,
    ) {
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            page: Data::int($data, 'page'),
            nombreParPage: Data::int($data, 'nombre_par_page'),
            totalResultats: Data::int($data, 'total_resultats'),
            resultats: Data::objectList($data, 'resultats', ActiviteTrouvee::fromArray(...)),
        );
    }
}
