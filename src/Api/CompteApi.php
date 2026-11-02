<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Api;

use EntreprisePage\ApiClient\Http\Transport;
use EntreprisePage\ApiClient\Model\Quota;

final class CompteApi
{
    /**
     * @internal utiliser Client::compte()
     */
    private Transport $transport;

    public function __construct(Transport $transport)
    {
        $this->transport = $transport;
    }

    /**
     * GET /quota — nécessite une clé d'API.
     */
    public function quota(): Quota
    {
        return Quota::fromArray($this->transport->get('/quota'));
    }
}
