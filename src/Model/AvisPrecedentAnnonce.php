<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final readonly class AvisPrecedentAnnonce
{
    public function __construct(
        /**
         * Exemple : "2020-05-14"
         */
        public ?string $dateParution,
        /**
         * Exemple : "BODACC A"
         */
        public string $nomPublication,
        /**
         * Exemple : "1337"
         */
        public string $numeroAnnonce,
        /**
         * Exemple : "20200100"
         */
        public string $numeroParution,
    ) {
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            dateParution: Data::nullableString($data, 'date_parution'),
            nomPublication: Data::string($data, 'nom_publication'),
            numeroAnnonce: Data::string($data, 'numero_annonce'),
            numeroParution: Data::string($data, 'numero_parution'),
        );
    }
}
