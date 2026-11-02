<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Api;

use EntreprisePage\ApiClient\Http\Transport;
use EntreprisePage\ApiClient\Hydration\Data;
use EntreprisePage\ApiClient\Model\Convention;

final class ConventionCollectiveApi
{
    /**
     * @internal utiliser Client::conventionsCollectives()
     */
    private Transport $transport;

    public function __construct(Transport $transport)
    {
        $this->transport = $transport;
    }

    /**
     * GET /dictionnaire/convention-collective
     *
     * @return list<Convention>
     */
    public function list(): array
    {
        return Data::mapList($this->transport->get('/dictionnaire/convention-collective'), [Convention::class, 'fromArray']);
    }

    /**
     * GET /dictionnaire/convention-collective/{code}
     *
     * @param string $idcc code IDCC, par exemple « 1486 »
     */
    public function get(string $idcc): Convention
    {
        return Convention::fromArray($this->transport->get('/dictionnaire/convention-collective/'.Transport::segment($idcc)));
    }
}
