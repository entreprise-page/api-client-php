<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final class SuiviCreationListe
{
    /**
     * Exemple : "Partenaires"
     *
     * @readonly
     */
    public string $nom;

    public function __construct(
        string $nom
    ) {
        $this->nom = $nom;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Data::string($data, 'nom'),
        );
    }
}
