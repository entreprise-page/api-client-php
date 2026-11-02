<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final readonly class Registre
{
    public function __construct(
        public RegistreDate $insee,
        public ?RegistreDateCessation $rcs,
        public ?RegistreDateCessation $rne,
    ) {
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            insee: Data::object($data, 'insee', RegistreDate::fromArray(...)),
            rcs: Data::nullableObject($data, 'rcs', RegistreDateCessation::fromArray(...)),
            rne: Data::nullableObject($data, 'rne', RegistreDateCessation::fromArray(...)),
        );
    }
}
