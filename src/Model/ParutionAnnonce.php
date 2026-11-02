<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final class ParutionAnnonce
{
    /**
     * Exemple : "2020-06-28"
     *
     * @readonly
     */
    public ?string $date;

    /**
     * Exemple : "20200122"
     *
     * @readonly
     */
    public string $numero;

    /**
     * Exemple : 1441
     *
     * @readonly
     */
    public int $numeroAnnonce;

    /**
     * Exemple : "A"
     *
     * @readonly
     */
    public string $publication;

    /**
     * Exemple : "https://www.bodacc.fr/pages/annonces-commerciales-detail/?q.id=id:A202001221441"
     *
     * @readonly
     */
    public string $url;

    public function __construct(
        ?string $date,
        string $numero,
        int $numeroAnnonce,
        string $publication,
        string $url
    ) {
        $this->date = $date;
        $this->numero = $numero;
        $this->numeroAnnonce = $numeroAnnonce;
        $this->publication = $publication;
        $this->url = $url;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Data::nullableString($data, 'date'),
            Data::string($data, 'numero'),
            Data::int($data, 'numero_annonce'),
            Data::string($data, 'publication'),
            Data::string($data, 'url'),
        );
    }
}
