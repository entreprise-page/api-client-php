<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final class Effectif
{
    /**
     * Exemple : true
     *
     * @readonly
     */
    public bool $estEmployeur;

    /**
     * @var list<EffectifAnnee>
     * @readonly
     */
    public array $historiques;

    /**
     * @param list<EffectifAnnee> $historiques
     */
    public function __construct(
        bool $estEmployeur,
        array $historiques
    ) {
        $this->estEmployeur = $estEmployeur;
        $this->historiques = $historiques;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Data::bool($data, 'est_employeur'),
            Data::objectList($data, 'historiques', [EffectifAnnee::class, 'fromArray']),
        );
    }
}
