<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final readonly class Departement
{
    public function __construct(
        /**
         * Exemple : "75"
         */
        public string $code,
        /**
         * Exemple : "Seine"
         */
        public string $libelle,
    ) {
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            code: Data::string($data, 'code'),
            libelle: Data::string($data, 'libelle'),
        );
    }
}
