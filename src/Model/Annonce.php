<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final readonly class Annonce
{
    public function __construct(
        /**
         * Exemple : "A202001221441"
         */
        public string $id,
        /**
         * Exemple : "vente"
         */
        public string $famille,
        /**
         * Exemple : "annonce"
         */
        public string $typeAvis,
        /**
         * Exemple : "2020-06-28"
         */
        public ?string $dateParution,
        public ?ActeAnnonce $acte,
        public ?AvisPrecedentAnnonce $avisPrecedent,
        public ?DepotAnnonce $depot,
        public ?EtablissementAnnonce $etablissement,
        public ?JugementAnnonce $jugement,
        public ?ModificationAnnonce $modification,
        /**
         * Exemple : "75"
         */
        public ?string $numeroDepartement,
        public ParutionAnnonce $parution,
        /**
         * @var list<PersonneAnnonce>
         */
        public array $personnes,
        /**
         * @var list<PersonneAnnonce>
         */
        public array $precedentsExploitants,
        /**
         * @var list<PersonneAnnonce>
         */
        public array $precedentsProprietaires,
        public ?RadiationAnnonce $radiation,
        /**
         * Exemple : "Paris"
         */
        public ?string $tribunal,
    ) {
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: Data::string($data, 'id'),
            famille: Data::string($data, 'famille'),
            typeAvis: Data::string($data, 'type_avis'),
            dateParution: Data::nullableString($data, 'date_parution'),
            acte: Data::nullableObject($data, 'acte', ActeAnnonce::fromArray(...)),
            avisPrecedent: Data::nullableObject($data, 'avis_precedent', AvisPrecedentAnnonce::fromArray(...)),
            depot: Data::nullableObject($data, 'depot', DepotAnnonce::fromArray(...)),
            etablissement: Data::nullableObject($data, 'etablissement', EtablissementAnnonce::fromArray(...)),
            jugement: Data::nullableObject($data, 'jugement', JugementAnnonce::fromArray(...)),
            modification: Data::nullableObject($data, 'modification', ModificationAnnonce::fromArray(...)),
            numeroDepartement: Data::nullableString($data, 'numero_departement'),
            parution: Data::object($data, 'parution', ParutionAnnonce::fromArray(...)),
            personnes: Data::objectList($data, 'personnes', PersonneAnnonce::fromArray(...)),
            precedentsExploitants: Data::objectList($data, 'precedents_exploitants', PersonneAnnonce::fromArray(...)),
            precedentsProprietaires: Data::objectList($data, 'precedents_proprietaires', PersonneAnnonce::fromArray(...)),
            radiation: Data::nullableObject($data, 'radiation', RadiationAnnonce::fromArray(...)),
            tribunal: Data::nullableString($data, 'tribunal'),
        );
    }
}
