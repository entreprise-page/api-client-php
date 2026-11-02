<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final class VenteAnnonce
{
    /**
     * Exemple : "Vente"
     *
     * @readonly
     */
    public ?string $categorie;

    /**
     * Exemple : "2020-06-20"
     *
     * @readonly
     */
    public ?string $dateEffet;

    /**
     * Exemple : "2020-06-22"
     *
     * @readonly
     */
    public ?string $datePublicite;

    /**
     * @var list<string>
     * @readonly
     */
    public array $oppositions;

    /**
     * @readonly
     */
    public ?string $publiciteLegale;

    /**
     * @param list<string> $oppositions
     */
    public function __construct(
        ?string $categorie,
        ?string $dateEffet,
        ?string $datePublicite,
        array $oppositions,
        ?string $publiciteLegale
    ) {
        $this->categorie = $categorie;
        $this->dateEffet = $dateEffet;
        $this->datePublicite = $datePublicite;
        $this->oppositions = $oppositions;
        $this->publiciteLegale = $publiciteLegale;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Data::nullableString($data, 'categorie'),
            Data::nullableString($data, 'date_effet'),
            Data::nullableString($data, 'date_publicite'),
            Data::stringList($data, 'oppositions'),
            Data::nullableString($data, 'publicite_legale'),
        );
    }
}
