<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Api;

use EntreprisePage\ApiClient\Http\Transport;
use EntreprisePage\ApiClient\Hydration\Data;
use EntreprisePage\ApiClient\Model\Annonce;

final readonly class AnnonceApi
{
    /**
     * @internal utiliser Client::annonces()
     */
    public function __construct(private Transport $transport)
    {
    }

    /**
     * GET /organisation/entreprise/{siren}/annonce — annonces BODACC, de la plus récente
     * à la plus ancienne, hors dépôts des comptes annuels. Nécessite une clé d'API.
     *
     * @return list<Annonce>
     */
    public function listerParSiren(string $siren): array
    {
        return Data::mapList(
            $this->transport->get('/organisation/entreprise/'.Transport::segment($siren).'/annonce'),
            Annonce::fromArray(...),
        );
    }
}
