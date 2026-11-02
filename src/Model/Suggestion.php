<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final readonly class Suggestion
{
    public function __construct(
        /**
         * Exemple : "443061841"
         */
        public string $siren,
        /**
         * Exemple : "Google France"
         */
        public string $nom,
        /**
         * Exemple : "75009"
         */
        public string $localite,
        /**
         * Exemple : "Programmation, conseil et autres activités informatiques"
         */
        public string $activite,
        /**
         * Exemple : true
         */
        public bool $active,
        /**
         * Exemple : "google-france-443061841"
         */
        public string $slug,
    ) {
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            siren: Data::string($data, 'siren'),
            nom: Data::string($data, 'nom'),
            localite: Data::string($data, 'localite'),
            activite: Data::string($data, 'activite'),
            active: Data::bool($data, 'active'),
            slug: Data::string($data, 'slug'),
        );
    }
}
