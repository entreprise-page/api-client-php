<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final class PersonnePhysique
{
    /**
     * Exemple : true
     *
     * @readonly
     */
    public bool $actif;

    /**
     * Exemple : "1980-01"
     *
     * @readonly
     */
    public ?string $dateNaissance;

    /**
     * Exemple : "Dupont"
     *
     * @readonly
     */
    public string $nom;

    /**
     * Exemple : "Pierre"
     *
     * @readonly
     */
    public ?string $prenom;

    /**
     * Exemple : "Chef d'entreprise"
     *
     * @readonly
     */
    public ?string $role;

    public function __construct(
        bool $actif,
        ?string $dateNaissance,
        string $nom,
        ?string $prenom,
        ?string $role
    ) {
        $this->actif = $actif;
        $this->dateNaissance = $dateNaissance;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->role = $role;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Data::bool($data, 'actif'),
            Data::nullableString($data, 'date_naissance'),
            Data::string($data, 'nom'),
            Data::nullableString($data, 'prenom'),
            Data::nullableString($data, 'role'),
        );
    }
}
