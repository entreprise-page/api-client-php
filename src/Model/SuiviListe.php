<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final class SuiviListe
{
    /**
     * Exemple : 1
     *
     * @readonly
     */
    public int $id;

    /**
     * Exemple : "Prospects"
     *
     * @readonly
     */
    public string $nom;

    public function __construct(
        int $id,
        string $nom
    ) {
        $this->id = $id;
        $this->nom = $nom;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Data::int($data, 'id'),
            Data::string($data, 'nom'),
        );
    }
}
