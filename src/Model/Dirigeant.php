<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final class Dirigeant
{
    /**
     * @var list<PersonneMorale>
     * @readonly
     */
    public array $personneMorale;

    /**
     * @var list<PersonnePhysique>
     * @readonly
     */
    public array $personnePhysique;

    /**
     * @param list<PersonneMorale> $personneMorale
     * @param list<PersonnePhysique> $personnePhysique
     */
    public function __construct(
        array $personneMorale,
        array $personnePhysique
    ) {
        $this->personneMorale = $personneMorale;
        $this->personnePhysique = $personnePhysique;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Data::objectList($data, 'personne_morale', [PersonneMorale::class, 'fromArray']),
            Data::objectList($data, 'personne_physique', [PersonnePhysique::class, 'fromArray']),
        );
    }
}
