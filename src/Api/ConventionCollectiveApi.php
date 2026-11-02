<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Api;

use EntreprisePage\ApiClient\Http\Transport;
use EntreprisePage\ApiClient\Hydration\Data;
use EntreprisePage\ApiClient\Model\Convention;

final readonly class ConventionCollectiveApi
{
    /**
     * @internal utiliser Client::conventionsCollectives()
     */
    public function __construct(private Transport $transport)
    {
    }

    /**
     * GET /dictionnaire/convention-collective
     *
     * @return list<Convention>
     */
    public function lister(): array
    {
        return Data::mapList($this->transport->get('/dictionnaire/convention-collective'), Convention::fromArray(...));
    }

    /**
     * GET /dictionnaire/convention-collective/{code}
     *
     * @param string $idcc code IDCC, par exemple « 1486 »
     */
    public function recuperer(string $idcc): Convention
    {
        return Convention::fromArray($this->transport->get('/dictionnaire/convention-collective/'.Transport::segment($idcc)));
    }
}
