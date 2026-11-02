<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Api;

use EntreprisePage\ApiClient\Http\Transport;
use EntreprisePage\ApiClient\Hydration\Data;
use EntreprisePage\ApiClient\Model\Activite;
use EntreprisePage\ApiClient\Model\RechercheActivite;
use EntreprisePage\ApiClient\Query\RechercheActiviteQuery;

final class ActiviteApi
{
    /**
     * @internal utiliser Client::activites()
     */
    private Transport $transport;

    public function __construct(Transport $transport)
    {
        $this->transport = $transport;
    }

    /**
     * GET /dictionnaire/activite.
     *
     * @return list<Activite>
     */
    public function list(): array
    {
        return Data::mapList($this->transport->get('/dictionnaire/activite'), [Activite::class, 'fromArray']);
    }

    /**
     * GET /dictionnaire/activite/{code}.
     *
     * @param string $code code APE, par exemple « 62.02A »
     */
    public function get(string $code): Activite
    {
        return Activite::fromArray($this->transport->get('/dictionnaire/activite/'.Transport::segment($code)));
    }

    /**
     * GET /dictionnaire/recherche/activite — retrouve des codes NAF depuis un terme courant.
     * Les codes obtenus s'utilisent dans RechercheEntrepriseQuery::withActivites().
     *
     * @param RechercheActiviteQuery|string $query
     */
    public function search($query): RechercheActivite
    {
        if (!$query instanceof RechercheActiviteQuery) {
            $query = RechercheActiviteQuery::create($query);
        }

        return RechercheActivite::fromArray($this->transport->get('/dictionnaire/recherche/activite', $query->toQuery()));
    }
}
