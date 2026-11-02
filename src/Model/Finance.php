<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final class Finance
{
    /**
     * Exemple : 2025
     *
     * @readonly
     */
    public int $annee;

    /**
     * Exemple : 568000
     *
     * @readonly
     */
    public float $chiffreAffaire;

    /**
     * Exemple : 268000
     *
     * @readonly
     */
    public float $margeBrut;

    /**
     * Exemple : 368000
     *
     * @readonly
     */
    public float $resultatNet;

    public function __construct(
        int $annee,
        float $chiffreAffaire,
        float $margeBrut,
        float $resultatNet
    ) {
        $this->annee = $annee;
        $this->chiffreAffaire = $chiffreAffaire;
        $this->margeBrut = $margeBrut;
        $this->resultatNet = $resultatNet;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Data::int($data, 'annee'),
            Data::float($data, 'chiffre_affaire'),
            Data::float($data, 'marge_brut'),
            Data::float($data, 'resultat_net'),
        );
    }
}
