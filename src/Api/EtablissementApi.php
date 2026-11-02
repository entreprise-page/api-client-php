<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Api;

use EntreprisePage\ApiClient\Http\Transport;
use EntreprisePage\ApiClient\Hydration\Data;
use EntreprisePage\ApiClient\Model\Etablissement;
use EntreprisePage\ApiClient\Query\EtablissementsQuery;

final class EtablissementApi
{
    /**
     * @internal utiliser Client::etablissements()
     */
    private Transport $transport;

    public function __construct(Transport $transport)
    {
        $this->transport = $transport;
    }

    /**
     * GET /organisation/etablissement/{siret} — nécessite une clé d'API.
     */
    public function get(string $siret): Etablissement
    {
        return Etablissement::fromArray($this->transport->get('/organisation/etablissement/'.Transport::segment($siret)));
    }

    /**
     * GET /organisation/entreprise/{siren}/etablissement — nécessite une clé d'API.
     *
     * @return list<Etablissement>
     */
    public function listBySiren(string $siren, ?EtablissementsQuery $filtres = null): array
    {
        return Data::mapList(
            $this->transport->get('/organisation/entreprise/'.Transport::segment($siren).'/etablissement', null !== $filtres ? $filtres->toQuery() : []),
            [Etablissement::class, 'fromArray'],
        );
    }
}
