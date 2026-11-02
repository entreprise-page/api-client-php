<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final class EtablissementAnnonce
{
    /**
     * Exemple : "restauration rapide"
     *
     * @readonly
     */
    public ?string $activite;

    /**
     * @readonly
     */
    public ?AdresseAnnonce $adresse;

    /**
     * Exemple : "Chez Jean"
     *
     * @readonly
     */
    public ?string $enseigne;

    /**
     * Exemple : "Création"
     *
     * @readonly
     */
    public ?string $origineFonds;

    /**
     * Exemple : "Etablissement principal"
     *
     * @readonly
     */
    public ?string $qualite;

    public function __construct(
        ?string $activite,
        ?AdresseAnnonce $adresse,
        ?string $enseigne,
        ?string $origineFonds,
        ?string $qualite
    ) {
        $this->activite = $activite;
        $this->adresse = $adresse;
        $this->enseigne = $enseigne;
        $this->origineFonds = $origineFonds;
        $this->qualite = $qualite;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Data::nullableString($data, 'activite'),
            Data::nullableObject($data, 'adresse', [AdresseAnnonce::class, 'fromArray']),
            Data::nullableString($data, 'enseigne'),
            Data::nullableString($data, 'origine_fonds'),
            Data::nullableString($data, 'qualite'),
        );
    }
}
