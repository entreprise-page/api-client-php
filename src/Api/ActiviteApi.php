<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Api;

use EntreprisePage\ApiClient\Http\Transport;
use EntreprisePage\ApiClient\Hydration\Data;
use EntreprisePage\ApiClient\Model\Activite;
use EntreprisePage\ApiClient\Model\RechercheActivite;
use EntreprisePage\ApiClient\Query\RechercheActiviteQuery;

final readonly class ActiviteApi
{
    /**
     * @internal utiliser Client::activites()
     */
    public function __construct(private Transport $transport)
    {
    }

    /**
     * GET /dictionnaire/activite
     *
     * @return list<Activite>
     */
    public function lister(): array
    {
        return Data::mapList($this->transport->get('/dictionnaire/activite'), Activite::fromArray(...));
    }

    /**
     * GET /dictionnaire/activite/{code}
     *
     * @param string $code code APE, par exemple « 62.02A »
     */
    public function recuperer(string $code): Activite
    {
        return Activite::fromArray($this->transport->get('/dictionnaire/activite/'.Transport::segment($code)));
    }

    /**
     * GET /dictionnaire/recherche/activite — retrouve des codes NAF depuis un terme courant.
     * Les codes obtenus s'utilisent dans RechercheEntrepriseQuery::$activites.
     */
    public function rechercher(RechercheActiviteQuery|string $query): RechercheActivite
    {
        if (\is_string($query)) {
            $query = new RechercheActiviteQuery($query);
        }

        return RechercheActivite::fromArray($this->transport->get('/dictionnaire/recherche/activite', $query->toQuery()));
    }
}
