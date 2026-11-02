<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final readonly class FormeJuridique
{
    public function __construct(
        /**
         * Exemple : "EURL"
         */
        public ?string $abreviation,
        /**
         * Exemple : 5499
         */
        public int $code,
        /**
         * Exemple : "entreprise unipersonnelle à responsabilité limitée"
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
            abreviation: Data::nullableString($data, 'abreviation'),
            code: Data::int($data, 'code'),
            libelle: Data::string($data, 'libelle'),
        );
    }
}
