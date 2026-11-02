<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final readonly class Dirigeant
{
    public function __construct(
        /**
         * @var list<PersonneMorale>
         */
        public array $personneMorale,
        /**
         * @var list<PersonnePhysique>
         */
        public array $personnePhysique,
    ) {
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            personneMorale: Data::objectList($data, 'personne_morale', PersonneMorale::fromArray(...)),
            personnePhysique: Data::objectList($data, 'personne_physique', PersonnePhysique::fromArray(...)),
        );
    }
}
