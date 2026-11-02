<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Api;

use EntreprisePage\ApiClient\Http\Transport;
use EntreprisePage\ApiClient\Hydration\Data;
use EntreprisePage\ApiClient\Model\Etablissement;
use EntreprisePage\ApiClient\Query\EtablissementsQuery;

final readonly class EtablissementApi
{
    /**
     * @internal utiliser Client::etablissements()
     */
    public function __construct(private Transport $transport)
    {
    }

    /**
     * GET /organisation/etablissement/{siret} — nécessite une clé d'API.
     */
    public function recuperer(string $siret): Etablissement
    {
        return Etablissement::fromArray($this->transport->get('/organisation/etablissement/'.Transport::segment($siret)));
    }

    /**
     * GET /organisation/entreprise/{siren}/etablissement — nécessite une clé d'API.
     *
     * @return list<Etablissement>
     */
    public function listerParSiren(string $siren, ?EtablissementsQuery $filtres = null): array
    {
        return Data::mapList(
            $this->transport->get('/organisation/entreprise/'.Transport::segment($siren).'/etablissement', $filtres?->toQuery() ?? []),
            Etablissement::fromArray(...),
        );
    }
}
