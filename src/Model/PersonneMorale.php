<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final class PersonneMorale
{
    /**
     * Exemple : "ERNST & YOUNG ET AUTRES"
     *
     * @readonly
     */
    public string $denomination;

    /**
     * Exemple : "Commissaire aux comptes titulaire"
     *
     * @readonly
     */
    public ?string $role;

    /**
     * Exemple : "438476913"
     *
     * @readonly
     */
    public ?string $siren;

    public function __construct(
        string $denomination,
        ?string $role,
        ?string $siren
    ) {
        $this->denomination = $denomination;
        $this->role = $role;
        $this->siren = $siren;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Data::string($data, 'denomination'),
            Data::nullableString($data, 'role'),
            Data::nullableString($data, 'siren'),
        );
    }
}
