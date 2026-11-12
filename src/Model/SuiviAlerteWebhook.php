<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final class SuiviAlerteWebhook
{
    /**
     * Exemple : false
     *
     * @readonly
     */
    public bool $active;

    /**
     * Exemple : "5f1c9a0e"
     *
     * @readonly
     */
    public string $token;

    /**
     * Exemple : "https://exemple.fr/webhook"
     *
     * @readonly
     */
    public string $url;

    public function __construct(
        bool $active,
        string $token,
        string $url
    ) {
        $this->active = $active;
        $this->token = $token;
        $this->url = $url;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Data::bool($data, 'active'),
            Data::string($data, 'token'),
            Data::string($data, 'url'),
        );
    }
}
