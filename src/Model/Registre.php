<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final class Registre
{
    /**
     * @readonly
     */
    public RegistreDate $insee;

    /**
     * @readonly
     */
    public ?RegistreDateCessation $rcs;

    /**
     * @readonly
     */
    public ?RegistreDateCessation $rne;

    public function __construct(
        RegistreDate $insee,
        ?RegistreDateCessation $rcs,
        ?RegistreDateCessation $rne
    ) {
        $this->insee = $insee;
        $this->rcs = $rcs;
        $this->rne = $rne;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Data::object($data, 'insee', [RegistreDate::class, 'fromArray']),
            Data::nullableObject($data, 'rcs', [RegistreDateCessation::class, 'fromArray']),
            Data::nullableObject($data, 'rne', [RegistreDateCessation::class, 'fromArray']),
        );
    }
}
