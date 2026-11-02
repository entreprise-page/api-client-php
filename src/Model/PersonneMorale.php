<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final readonly class PersonneMorale
{
    public function __construct(
        /**
         * Exemple : "ERNST & YOUNG ET AUTRES"
         */
        public string $denomination,
        /**
         * Exemple : "Commissaire aux comptes titulaire"
         */
        public ?string $role,
        /**
         * Exemple : "438476913"
         */
        public ?string $siren,
    ) {
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            denomination: Data::string($data, 'denomination'),
            role: Data::nullableString($data, 'role'),
            siren: Data::nullableString($data, 'siren'),
        );
    }
}
