<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final class AvisPrecedentAnnonce
{
    /**
     * Exemple : "2020-05-14"
     *
     * @readonly
     */
    public ?string $dateParution;

    /**
     * Exemple : "BODACC A"
     *
     * @readonly
     */
    public string $nomPublication;

    /**
     * Exemple : "1337"
     *
     * @readonly
     */
    public string $numeroAnnonce;

    /**
     * Exemple : "20200100"
     *
     * @readonly
     */
    public string $numeroParution;

    public function __construct(
        ?string $dateParution,
        string $nomPublication,
        string $numeroAnnonce,
        string $numeroParution
    ) {
        $this->dateParution = $dateParution;
        $this->nomPublication = $nomPublication;
        $this->numeroAnnonce = $numeroAnnonce;
        $this->numeroParution = $numeroParution;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Data::nullableString($data, 'date_parution'),
            Data::string($data, 'nom_publication'),
            Data::string($data, 'numero_annonce'),
            Data::string($data, 'numero_parution'),
        );
    }
}
