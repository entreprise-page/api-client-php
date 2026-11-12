<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final class SuiviConfigurationAlerteEmail
{
    /**
     * Exemple : true
     *
     * @readonly
     */
    public bool $active;

    /**
     * Exemple : ["veille@exemple.fr"]
     *
     * @var list<string>
     * @readonly
     */
    public array $adresses;

    /**
     * @param list<string> $adresses
     */
    public function __construct(
        bool $active,
        array $adresses
    ) {
        $this->active = $active;
        $this->adresses = $adresses;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Data::bool($data, 'active'),
            Data::stringList($data, 'adresses'),
        );
    }
}
