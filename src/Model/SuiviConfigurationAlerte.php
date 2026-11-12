<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final class SuiviConfigurationAlerte
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
    public SuiviConfigurationAlerteEmail $email;

    /**
     * Exemple : ["fermeture_entreprise","changement_denomination"]
     *
     * @var list<string>
     * @readonly
     */
    public array $evenements;

    /**
     * @readonly
     */
    public SuiviConfigurationAlerteWebhook $webhook;

    /**
     * @param list<string> $evenements
     */
    public function __construct(
        bool $active,
        SuiviConfigurationAlerteEmail $email,
        array $evenements,
        SuiviConfigurationAlerteWebhook $webhook
    ) {
        $this->active = $active;
        $this->email = $email;
        $this->evenements = $evenements;
        $this->webhook = $webhook;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Data::bool($data, 'active'),
            Data::object($data, 'email', [SuiviConfigurationAlerteEmail::class, 'fromArray']),
            Data::stringList($data, 'evenements'),
            Data::object($data, 'webhook', [SuiviConfigurationAlerteWebhook::class, 'fromArray']),
        );
    }
}
