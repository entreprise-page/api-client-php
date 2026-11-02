<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final class ActeAnnonce
{
    /**
     * Exemple : "Création d'un fonds de commerce"
     *
     * @readonly
     */
    public ?string $categorieCreation;

    /**
     * Exemple : "Immatriculation d'une société"
     *
     * @readonly
     */
    public ?string $categorieImmatriculation;

    /**
     * Exemple : "2020-06-15"
     *
     * @readonly
     */
    public ?string $dateCommencementActivite;

    /**
     * Exemple : "2020-06-01"
     *
     * @readonly
     */
    public ?string $dateImmatriculation;

    /**
     * @readonly
     */
    public ?string $descriptif;

    /**
     * @readonly
     */
    public ?VenteAnnonce $vente;

    public function __construct(
        ?string $categorieCreation,
        ?string $categorieImmatriculation,
        ?string $dateCommencementActivite,
        ?string $dateImmatriculation,
        ?string $descriptif,
        ?VenteAnnonce $vente
    ) {
        $this->categorieCreation = $categorieCreation;
        $this->categorieImmatriculation = $categorieImmatriculation;
        $this->dateCommencementActivite = $dateCommencementActivite;
        $this->dateImmatriculation = $dateImmatriculation;
        $this->descriptif = $descriptif;
        $this->vente = $vente;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Data::nullableString($data, 'categorie_creation'),
            Data::nullableString($data, 'categorie_immatriculation'),
            Data::nullableString($data, 'date_commencement_activite'),
            Data::nullableString($data, 'date_immatriculation'),
            Data::nullableString($data, 'descriptif'),
            Data::nullableObject($data, 'vente', [VenteAnnonce::class, 'fromArray']),
        );
    }
}
