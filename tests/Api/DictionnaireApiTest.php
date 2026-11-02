<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Tests\Api;

use EntreprisePage\ApiClient\Query\RechercheActiviteQuery;
use EntreprisePage\ApiClient\Tests\ApiTestCase;

final class DictionnaireApiTest extends ApiTestCase
{
    public function testRechercherUneActivite(): void
    {
        $this->http->willRespondWithFixture('recherche_activite.json');

        $resultat = $this->client->activites()->search(RechercheActiviteQuery::create('plombier')->withSection('Construction')->withPage(1)->withParPage(2));

        self::assertSame('/v1/dictionnaire/recherche/activite', $this->http->lastRequest()->getUri()->getPath());
        self::assertSame(['query' => 'plombier', 'section' => 'Construction', 'page' => '1', 'par_page' => '2'], $this->lastQuery());
        self::assertSame('43.22A', $resultat->resultats[0]->code);
        self::assertContains('plombier', $resultat->resultats[0]->motsCles);
    }

    public function testRecupererEncodeLeCodeDansLeChemin(): void
    {
        $this->http->willRespond(200, '{"code":"62.02A","libelle":"Conseil en systèmes et logiciels informatiques","section":null}');

        $activite = $this->client->activites()->get('62.02A');

        self::assertSame('/v1/dictionnaire/activite/62.02A', $this->http->lastRequest()->getUri()->getPath());
        self::assertNull($activite->section);
    }

    public function testListerLesFormesJuridiques(): void
    {
        $this->http->willRespond(200, '[{"libelle":"entreprise unipersonnelle à responsabilité limitée","code":5499,"abreviation":"EURL"}]');

        $formes = $this->client->formesJuridiques()->list();

        self::assertSame('/v1/dictionnaire/forme-juridique', $this->http->lastRequest()->getUri()->getPath());
        self::assertSame('EURL', $formes[0]->abreviation);
    }

    public function testRecupererUneConventionCollective(): void
    {
        $this->http->willRespond(200, '{"idcc":1486,"libelle":"SYNTEC"}');

        $convention = $this->client->conventionsCollectives()->get('1486');

        self::assertSame('/v1/dictionnaire/convention-collective/1486', $this->http->lastRequest()->getUri()->getPath());
        self::assertSame(1486, $convention->idcc);
    }

    public function testQuota(): void
    {
        $this->http->willRespond(200, '{"total":12,"max":1000}');

        $quota = $this->client->compte()->quota();

        self::assertSame('/v1/quota', $this->http->lastRequest()->getUri()->getPath());
        self::assertSame(12, $quota->total);
        self::assertSame(1000, $quota->max);
    }
}
