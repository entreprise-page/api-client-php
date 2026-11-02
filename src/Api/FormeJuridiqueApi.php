<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Api;

use EntreprisePage\ApiClient\Http\Transport;
use EntreprisePage\ApiClient\Hydration\Data;
use EntreprisePage\ApiClient\Model\FormeJuridique;

final readonly class FormeJuridiqueApi
{
    /**
     * @internal utiliser Client::formesJuridiques()
     */
    public function __construct(private Transport $transport)
    {
    }

    /**
     * GET /dictionnaire/forme-juridique
     *
     * @return list<FormeJuridique>
     */
    public function lister(): array
    {
        return Data::mapList($this->transport->get('/dictionnaire/forme-juridique'), FormeJuridique::fromArray(...));
    }

    /**
     * GET /dictionnaire/forme-juridique/{code}
     *
     * @param string $code code de forme juridique, par exemple « 5499 »
     */
    public function recuperer(string $code): FormeJuridique
    {
        return FormeJuridique::fromArray($this->transport->get('/dictionnaire/forme-juridique/'.Transport::segment($code)));
    }
}
