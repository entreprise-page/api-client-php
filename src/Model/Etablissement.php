<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final readonly class Etablissement
{
    public function __construct(
        public Activite $activitePrincipaleExercee,
        public Adresse $adresse,
        public ?Convention $conventionCollective,
        /**
         * Exemple : "FRGOOGLE"
         */
        public ?string $enseigne,
        /**
         * Exemple : true
         */
        public bool $estActif,
        /**
         * Exemple : true
         */
        public bool $estSiege,
        /**
         * Exemple : ["google.fr"]
         * @var list<string>
         */
        public array $nomsDeDomaine,
        /**
         * Exemple : "44306184100047"
         */
        public string $siret,
    ) {
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            activitePrincipaleExercee: Data::object($data, 'activite_principale_exercee', Activite::fromArray(...)),
            adresse: Data::object($data, 'adresse', Adresse::fromArray(...)),
            conventionCollective: Data::nullableObject($data, 'convention_collective', Convention::fromArray(...)),
            enseigne: Data::nullableString($data, 'enseigne'),
            estActif: Data::bool($data, 'est_actif'),
            estSiege: Data::bool($data, 'est_siege'),
            nomsDeDomaine: Data::stringList($data, 'noms_de_domaine'),
            siret: Data::string($data, 'siret'),
        );
    }
}
