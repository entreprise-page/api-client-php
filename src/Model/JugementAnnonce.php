<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final class JugementAnnonce
{
    /**
     * @readonly
     */
    public ?string $complement;

    /**
     * Exemple : "2020-06-18"
     *
     * @readonly
     */
    public ?string $date;

    /**
     * Exemple : "Jugement d'ouverture"
     *
     * @readonly
     */
    public string $famille;

    /**
     * Exemple : "Liquidation judiciaire"
     *
     * @readonly
     */
    public string $nature;

    public function __construct(
        ?string $complement,
        ?string $date,
        string $famille,
        string $nature
    ) {
        $this->complement = $complement;
        $this->date = $date;
        $this->famille = $famille;
        $this->nature = $nature;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Data::nullableString($data, 'complement'),
            Data::nullableString($data, 'date'),
            Data::string($data, 'famille'),
            Data::string($data, 'nature'),
        );
    }
}
