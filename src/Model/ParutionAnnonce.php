<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final readonly class ParutionAnnonce
{
    public function __construct(
        /**
         * Exemple : "2020-06-28"
         */
        public ?string $date,
        /**
         * Exemple : "20200122"
         */
        public string $numero,
        /**
         * Exemple : 1441
         */
        public int $numeroAnnonce,
        /**
         * Exemple : "A"
         */
        public string $publication,
        /**
         * Exemple : "https://www.bodacc.fr/pages/annonces-commerciales-detail/?q.id=id:A202001221441"
         */
        public string $url,
    ) {
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            date: Data::nullableString($data, 'date'),
            numero: Data::string($data, 'numero'),
            numeroAnnonce: Data::int($data, 'numero_annonce'),
            publication: Data::string($data, 'publication'),
            url: Data::string($data, 'url'),
        );
    }
}
