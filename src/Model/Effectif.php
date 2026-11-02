<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final readonly class Effectif
{
    public function __construct(
        /**
         * Exemple : true
         */
        public bool $estEmployeur,
        /**
         * @var list<EffectifAnnee>
         */
        public array $historiques,
    ) {
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            estEmployeur: Data::bool($data, 'est_employeur'),
            historiques: Data::objectList($data, 'historiques', EffectifAnnee::fromArray(...)),
        );
    }
}
