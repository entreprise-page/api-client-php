<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Tests\Api;

use EntreprisePage\ApiClient\Query\EtablissementsQuery;
use EntreprisePage\ApiClient\Tests\ApiTestCase;

final class EtablissementApiTest extends ApiTestCase
{
    public function testRecuperer(): void
    {
        $this->http->willRespond(200, json_encode($this->premierEtablissement(), \JSON_THROW_ON_ERROR));

        $etablissement = $this->client->etablissements()->get('00974386500017');

        self::assertSame('/v1/organisation/etablissement/00974386500017', $this->http->lastRequest()->getUri()->getPath());
        self::assertSame('00974386500017', $etablissement->siret);
        self::assertTrue($etablissement->estSiege);
    }

    public function testListerParSirenAvecFiltres(): void
    {
        $this->http->willRespondWithFixture('etablissements.json');

        $etablissements = $this->client->etablissements()->listBySiren('009743865', new EtablissementsQuery(
            actifs: true,
            activites: ['81.10Z'],
            codesPostaux: ['35000', '35200'],
            numerosDepartements: ['35'],
        ));

        self::assertSame('/v1/organisation/entreprise/009743865/etablissement', $this->http->lastRequest()->getUri()->getPath());
        self::assertSame([
            'actifs' => 'true',
            'activites' => '81.10Z',
            'code_postaux' => '35000,35200',
            'numeros_departements' => '35',
        ], $this->lastQuery());
        self::assertCount(1, $etablissements);
    }

    public function testListerParSirenSansFiltre(): void
    {
        $this->http->willRespondWithFixture('etablissements.json');

        $this->client->etablissements()->listBySiren('009743865');

        self::assertSame('', $this->http->lastRequest()->getUri()->getQuery());
    }

    /**
     * @return array<mixed>
     */
    private function premierEtablissement(): array
    {
        $liste = json_decode((string) file_get_contents(__DIR__.'/../Fixtures/etablissements.json'), true, 512, \JSON_THROW_ON_ERROR);
        self::assertIsArray($liste);
        self::assertIsArray($liste[0]);

        return $liste[0];
    }
}
