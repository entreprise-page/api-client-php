<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final readonly class RegistreDateCessation
{
    public function __construct(
        /**
         * Exemple : "2002-08-14"
         */
        public ?string $dateCessation,
        /**
         * Exemple : "2002-08-14"
         */
        public ?string $dateCreation,
        /**
         * Exemple : "2002-08-14"
         */
        public ?string $dateMiseAJour,
    ) {
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            dateCessation: Data::nullableString($data, 'date_cessation'),
            dateCreation: Data::nullableString($data, 'date_creation'),
            dateMiseAJour: Data::nullableString($data, 'date_mise_a_jour'),
        );
    }
}
