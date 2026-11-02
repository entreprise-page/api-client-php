<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final class Activite
{
    /**
     * Exemple : "62.02A"
     *
     * @readonly
     */
    public string $code;

    /**
     * Exemple : "Conseil en systèmes et logiciels informatiques"
     *
     * @readonly
     */
    public ?string $libelle;

    /**
     * Exemple : "Programmation, conseil et autres activités informatiques"
     *
     * @readonly
     */
    public ?string $section;

    public function __construct(
        string $code,
        ?string $libelle,
        ?string $section
    ) {
        $this->code = $code;
        $this->libelle = $libelle;
        $this->section = $section;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Data::string($data, 'code'),
            Data::nullableString($data, 'libelle'),
            Data::nullableString($data, 'section'),
        );
    }
}
