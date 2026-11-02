<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final readonly class ModificationAnnonce
{
    public function __construct(
        /**
         * Exemple : "2020-06-15"
         */
        public ?string $dateCommencementActivite,
        /**
         * Exemple : "2020-06-20"
         */
        public ?string $dateEffet,
        public ?string $descriptif,
    ) {
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            dateCommencementActivite: Data::nullableString($data, 'date_commencement_activite'),
            dateEffet: Data::nullableString($data, 'date_effet'),
            descriptif: Data::nullableString($data, 'descriptif'),
        );
    }
}
