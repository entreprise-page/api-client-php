<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final readonly class JugementAnnonce
{
    public function __construct(
        public ?string $complement,
        /**
         * Exemple : "2020-06-18"
         */
        public ?string $date,
        /**
         * Exemple : "Jugement d'ouverture"
         */
        public string $famille,
        /**
         * Exemple : "Liquidation judiciaire"
         */
        public string $nature,
    ) {
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            complement: Data::nullableString($data, 'complement'),
            date: Data::nullableString($data, 'date'),
            famille: Data::string($data, 'famille'),
            nature: Data::string($data, 'nature'),
        );
    }
}
