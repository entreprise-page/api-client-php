<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final class Pays
{
    /**
     * Exemple : "FR"
     *
     * @readonly
     */
    public string $code;

    /**
     * Exemple : "France"
     *
     * @readonly
     */
    public string $libelle;

    public function __construct(
        string $code,
        string $libelle
    ) {
        $this->code = $code;
        $this->libelle = $libelle;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Data::string($data, 'code'),
            Data::string($data, 'libelle'),
        );
    }
}
