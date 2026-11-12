<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Tests\Api;

use EntreprisePage\ApiClient\Exception\BadRequestException;
use EntreprisePage\ApiClient\Model\SuiviConfigurationAlerte;
use EntreprisePage\ApiClient\Model\SuiviConfigurationAlerteEmail;
use EntreprisePage\ApiClient\Model\SuiviConfigurationAlerteWebhook;
use EntreprisePage\ApiClient\Tests\ApiTestCase;

final class SuiviApiTest extends ApiTestCase
{
    public function testListerLesListes(): void
    {
        $this->http->willRespond(200, '{"listes":[{"id":1,"nom":"Clients"},{"id":3,"nom":"Prospects"}],"max_liste":5}');

        $listes = $this->client->suivi()->lists();

        $this->assertRequest('GET', '/suivi/liste');
        self::assertSame(5, $listes->maxListe);
        self::assertCount(2, $listes->listes);
        self::assertSame('Prospects', $listes->listes[1]->nom);
    }

    public function testCreerUneListeEnvoieSonNom(): void
    {
        $this->http->willRespond(201, '{"id":4,"nom":"Fournisseurs été"}');

        $liste = $this->client->suivi()->createList('Fournisseurs été');

        $this->assertRequest('POST', '/suivi/liste', ['nom' => 'Fournisseurs été']);
        self::assertSame(4, $liste->id);
    }

    public function testSupprimerUneListe(): void
    {
        $this->http->willRespond(204, '');

        $this->client->suivi()->deleteList(3);

        $this->assertRequest('DELETE', '/suivi/liste/3');
    }

    public function testListerLesEntreprisesDeLaPremiereListeParDefaut(): void
    {
        $this->http->willRespondWithFixture('suivi_liste_entreprise.json');

        $this->client->suivi()->companies();

        $this->assertRequest('GET', '/suivi/entreprise');
        self::assertSame('', $this->http->lastRequest()->getUri()->getQuery());
    }

    public function testListerLesEntreprisesDUneListePaginee(): void
    {
        $this->http->willRespondWithFixture('suivi_liste_entreprise.json');

        $liste = $this->client->suivi()->companies(3, 1, 2);

        self::assertSame(['liste' => '3', 'page' => '1', 'par_page' => '2'], $this->lastQuery());
        self::assertSame('Prospects', $liste->nom);
        self::assertSame(3, $liste->pagination->totalResultat);
        self::assertCount(2, $liste->entreprises);
        self::assertSame('TOTALENERGIES SE', $liste->entreprises[0]->denomination);
        self::assertNull($liste->entreprises[0]->dateEnCessation);
        self::assertNull($liste->entreprises[1]->denomination);
        self::assertNull($liste->entreprises[1]->activiteLibelle);
        self::assertFalse($liste->entreprises[1]->estActive);
    }

    public function testSavoirSiUneEntrepriseEstSuivie(): void
    {
        $this->http->willRespond(200, '{"est_suivie":true}')->willRespond(200, '{"est_suivie":false}');

        self::assertTrue($this->client->suivi()->isFollowed('552032534'));
        $this->assertRequest('GET', '/suivi/entreprise/552032534');
        self::assertFalse($this->client->suivi()->isFollowed('542051180'));
    }

    public function testSuivreUneEntreprise(): void
    {
        $this->http->willRespond(204, '');

        $this->client->suivi()->follow(3, '552032534');

        $this->assertRequest('POST', '/suivi/liste/3/entreprise', ['siren' => '552032534']);
    }

    public function testImporterUneListeDeSiren(): void
    {
        $this->http->willRespond(200, '{"succes":2,"erreur":1,"total":3}');

        $statut = $this->client->suivi()->import(3, ['552032534', '542051180', '000000000']);

        $this->assertRequest('POST', '/suivi/liste/3/import', ['sirens' => '552032534,542051180,000000000']);
        self::assertSame(2, $statut->succes);
        self::assertSame(1, $statut->erreur);
        self::assertSame(3, $statut->total);
    }

    public function testImporterUneChaineLaTransmetTelleQuelle(): void
    {
        $this->http->willRespond(200, '{"succes":2,"erreur":0,"total":2}');

        $this->client->suivi()->import(3, "552032534\n542051180");

        $this->assertRequest('POST', '/suivi/liste/3/import', ['sirens' => "552032534\n542051180"]);
    }

    public function testRetirerUneEntrepriseDUneListe(): void
    {
        $this->http->willRespond(204, '');

        $this->client->suivi()->removeFromList(3, '552032534');

        $this->assertRequest('DELETE', '/suivi/liste/3/entreprise/552032534');
    }

    public function testNePlusSuivreUneEntreprise(): void
    {
        $this->http->willRespond(204, '');

        $this->client->suivi()->unfollow('552032534');

        $this->assertRequest('DELETE', '/suivi/entreprise/552032534');
    }

    public function testLireLAlerte(): void
    {
        $this->http->willRespondWithFixture('suivi_alerte.json');

        $alerte = $this->client->suivi()->alert(3);

        $this->assertRequest('GET', '/suivi/liste/3/alerte');
        self::assertSame(3, $alerte->listeId);
        self::assertTrue($alerte->active);
        self::assertSame(['fermeture_entreprise', 'changement_denomination'], $alerte->evenements);
        self::assertSame(['veille@exemple.fr'], $alerte->email->adresses);
        self::assertFalse($alerte->webhook->active);
        self::assertSame('5f1c9a0e', $alerte->webhook->token);
        self::assertContains('changement_siege_social', $alerte->evenementsDisponibles);
    }

    public function testConfigurerLAlerteEnvoieToutesLesRubriques(): void
    {
        $this->http->willRespondWithFixture('suivi_alerte.json');

        $this->client->suivi()->configureAlert(3, new SuiviConfigurationAlerte(
            true,
            new SuiviConfigurationAlerteEmail(true, ['veille@exemple.fr']),
            ['fermeture_entreprise'],
            new SuiviConfigurationAlerteWebhook(false, '', 'https://exemple.fr/webhook'),
        ));

        $this->assertRequest('PUT', '/suivi/liste/3/alerte', [
            'active' => true,
            'evenements' => ['fermeture_entreprise'],
            'email' => ['active' => true, 'adresses' => ['veille@exemple.fr']],
            'webhook' => ['active' => false, 'url' => 'https://exemple.fr/webhook', 'token' => ''],
        ]);
    }

    public function testConfigurerSansEvenementEnvoieUneListeVide(): void
    {
        $this->http->willRespondWithFixture('suivi_alerte.json');

        $this->client->suivi()->configureAlert(3, new SuiviConfigurationAlerte(
            false,
            new SuiviConfigurationAlerteEmail(false, []),
            [],
            new SuiviConfigurationAlerteWebhook(false, '', ''),
        ));

        self::assertStringContainsString('"evenements":[]', (string) $this->http->lastRequest()->getBody());
        self::assertStringContainsString('"adresses":[]', (string) $this->http->lastRequest()->getBody());
    }

    public function testActiverEtDesactiverLAlerte(): void
    {
        $this->http->willRespondWithFixture('suivi_alerte.json')->willRespondWithFixture('suivi_alerte.json');

        $this->client->suivi()->enableAlert(3);
        $this->assertRequest('POST', '/suivi/liste/3/alerte/activer');

        $this->client->suivi()->disableAlert(3);
        $this->assertRequest('POST', '/suivi/liste/3/alerte/desactiver');
    }

    public function testRemonteLeMessageDErreurDuSuivi(): void
    {
        $this->http->willRespond(400, '{"erreur":"Nombre maximum de suivis atteint"}');

        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage('Nombre maximum de suivis atteint');

        $this->client->suivi()->follow(3, '552032534');
    }

    /**
     * @param array<string, mixed>|null $body corps JSON attendu, null pour une requête sans corps
     */
    private function assertRequest(string $method, string $path, ?array $body = null): void
    {
        $request = $this->http->lastRequest();

        self::assertSame($method, $request->getMethod());
        self::assertSame('/v1'.$path, $request->getUri()->getPath());
        self::assertSame('cle-de-test', $request->getHeaderLine('X-API-Key'));

        if (null === $body) {
            self::assertSame('', (string) $request->getBody());
            self::assertFalse($request->hasHeader('Content-Type'));

            return;
        }

        self::assertSame('application/json', $request->getHeaderLine('Content-Type'));
        self::assertSame($body, json_decode((string) $request->getBody(), true, 512, \JSON_THROW_ON_ERROR));
    }
}
