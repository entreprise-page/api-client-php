<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final class SuiviAlerte
{
    /**
     * Exemple : true
     *
     * @readonly
     */
    public bool $active;

    /**
     * @readonly
     */
    public SuiviAlerteEmail $email;

    /**
     * Exemple : ["fermeture_entreprise","changement_denomination"]
     *
     * @var list<string>
     * @readonly
     */
    public array $evenements;

    /**
     * EvenementsDisponibles sont ceux qu'une alerte peut demander.
     * Exemple : ["changement_siege_social","fermeture_entreprise"]
     *
     * @var list<string>
     * @readonly
     */
    public array $evenementsDisponibles;

    /**
     * Exemple : 1
     *
     * @readonly
     */
    public int $listeId;

    /**
     * @readonly
     */
    public SuiviAlerteWebhook $webhook;

    /**
     * @param list<string> $evenements
     * @param list<string> $evenementsDisponibles
     */
    public function __construct(
        bool $active,
        SuiviAlerteEmail $email,
        array $evenements,
        array $evenementsDisponibles,
        int $listeId,
        SuiviAlerteWebhook $webhook
    ) {
        $this->active = $active;
        $this->email = $email;
        $this->evenements = $evenements;
        $this->evenementsDisponibles = $evenementsDisponibles;
        $this->listeId = $listeId;
        $this->webhook = $webhook;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Data::bool($data, 'active'),
            Data::object($data, 'email', [SuiviAlerteEmail::class, 'fromArray']),
            Data::stringList($data, 'evenements'),
            Data::stringList($data, 'evenements_disponibles'),
            Data::int($data, 'liste_id'),
            Data::object($data, 'webhook', [SuiviAlerteWebhook::class, 'fromArray']),
        );
    }
}
