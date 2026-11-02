<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Tests\Api;

use EntreprisePage\ApiClient\Tests\ApiTestCase;

final class AnnonceApiTest extends ApiTestCase
{
    public function testListerParSiren(): void
    {
        $this->http->willRespondWithFixture('annonces.json');

        $annonces = $this->client->annonces()->listBySiren('443061841');

        self::assertSame('/v1/organisation/entreprise/443061841/annonce', $this->http->lastRequest()->getUri()->getPath());
        self::assertCount(1, $annonces);
        $annonce = $annonces[0];
        self::assertSame('A202001221441', $annonce->id);
        self::assertSame(1441, $annonce->parution->numeroAnnonce);
        self::assertSame(10000.0, $annonce->personnes[0]->capital?->montant);
        self::assertSame(['Au fonds vendu'], $annonce->acte?->vente?->oppositions);
        self::assertSame([], $annonce->precedentsProprietaires, 'une liste null est lue comme vide');
        self::assertNull($annonce->jugement);
        self::assertNull($annonce->depot, 'un objet nullable absent est lu comme null');
    }
}
