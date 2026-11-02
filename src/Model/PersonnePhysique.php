<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final readonly class PersonnePhysique
{
    public function __construct(
        /**
         * Exemple : "1980-01"
         */
        public ?string $dateNaissance,
        /**
         * Exemple : "Dupont"
         */
        public string $nom,
        /**
         * Exemple : "Pierre"
         */
        public ?string $prenom,
        /**
         * Exemple : "Chef d'entreprise"
         */
        public ?string $role,
    ) {
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            dateNaissance: Data::nullableString($data, 'date_naissance'),
            nom: Data::string($data, 'nom'),
            prenom: Data::nullableString($data, 'prenom'),
            role: Data::nullableString($data, 'role'),
        );
    }
}
