<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final readonly class Activite
{
    public function __construct(
        /**
         * Exemple : "62.02A"
         */
        public string $code,
        /**
         * Exemple : "Conseil en systèmes et logiciels informatiques"
         */
        public ?string $libelle,
        /**
         * Exemple : "Programmation, conseil et autres activités informatiques"
         */
        public ?string $section,
    ) {
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            code: Data::string($data, 'code'),
            libelle: Data::nullableString($data, 'libelle'),
            section: Data::nullableString($data, 'section'),
        );
    }
}
