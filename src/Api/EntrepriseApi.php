<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Api;

use EntreprisePage\ApiClient\Http\Transport;
use EntreprisePage\ApiClient\Hydration\Data;
use EntreprisePage\ApiClient\Model\Entreprise;
use EntreprisePage\ApiClient\Model\RechercheEntreprise;
use EntreprisePage\ApiClient\Model\Suggestion;
use EntreprisePage\ApiClient\Query\RechercheEntrepriseQuery;

final readonly class EntrepriseApi
{
    /**
     * @internal utiliser Client::entreprises()
     */
    public function __construct(private Transport $transport)
    {
    }

    /**
     * GET /organisation/entreprise/{siren} — nécessite une clé d'API.
     */
    public function recuperer(string $siren): Entreprise
    {
        return Entreprise::fromArray($this->transport->get('/organisation/entreprise/'.Transport::segment($siren)));
    }

    /**
     * GET /organisation/recherche — nécessite une clé d'API et consomme le quota.
     */
    public function rechercher(RechercheEntrepriseQuery|string $query): RechercheEntreprise
    {
        if (\is_string($query)) {
            $query = new RechercheEntrepriseQuery($query);
        }

        return RechercheEntreprise::fromArray($this->transport->get('/organisation/recherche', $query->toQuery()));
    }

    /**
     * GET /organisation/suggestion — autocomplétion, sans clé d'API.
     *
     * @param int|null $limit 1 à 10, 1 par défaut côté API
     *
     * @return list<Suggestion>
     */
    public function suggerer(string $query, ?int $limit = null): array
    {
        $params = ['query' => $query];
        if (null !== $limit) {
            $params['limit'] = (string) $limit;
        }

        return Data::mapList($this->transport->get('/organisation/suggestion', $params), Suggestion::fromArray(...));
    }
}
