<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Tests\Api;

use EntreprisePage\ApiClient\Query\RechercheEntrepriseQuery;
use EntreprisePage\ApiClient\Tests\ApiTestCase;

final class EntrepriseApiTest extends ApiTestCase
{
    public function testRecupererHydrateLEntreprise(): void
    {
        $this->http->willRespondWithFixture('entreprise.json');

        $entreprise = $this->client->entreprises()->get('009743865');

        self::assertSame('https://api.test/v1/organisation/entreprise/009743865', (string) $this->http->lastRequest()->getUri());
        self::assertSame('009743865', $entreprise->siren);
        self::assertSame('ASS COPRO 1 A 5 R VICTOR HUGO', $entreprise->denominationSociale);
        self::assertSame(9110, $entreprise->formeJuridique->code);
        self::assertNull($entreprise->formeJuridique->abreviation);
        self::assertNull($entreprise->capitalSocial);
        self::assertSame('RENNES', $entreprise->siegeSocial?->adresse->commune?->libelle);
        self::assertSame(48.112573, $entreprise->siegeSocial->adresse->coordonnees?->latitude);
        self::assertNull($entreprise->registre->rcs, 'rcs est omis par l\'API quand il est absent');
        self::assertSame([], $entreprise->finances);
    }

    public function testRechercherAvecUneChaine(): void
    {
        $this->http->willRespondWithFixture('recherche_entreprise.json');

        $resultat = $this->client->entreprises()->search('victor hugo');

        self::assertSame(['query' => 'victor hugo'], $this->lastQuery());
        self::assertSame(1, $resultat->page);
        self::assertCount(2, $resultat->resultats);
        self::assertSame('009743865', $resultat->resultats[0]->siren);
        self::assertNull($resultat->resultats[0]->distanceMetres);
    }

    public function testRechercherEncodeTousLesCriteres(): void
    {
        $this->http->willRespondWithFixture('recherche_entreprise.json');

        $this->client->entreprises()->search(new RechercheEntrepriseQuery(
            query: 'plombier',
            activites: ['43.22A', '43.22B'],
            categoriesJuridiques: [5499, 5710],
            actif: false,
            latitude: 45.7672724,
            longitude: 4.8340594,
            rayon: 15,
            page: 2,
            parPage: 50,
        ));

        self::assertSame([
            'query' => 'plombier',
            'activite' => '43.22A,43.22B',
            'categorie_juridique' => '5499,5710',
            'actif' => 'false',
            'latitude' => '45.7672724',
            'longitude' => '4.8340594',
            'rayon' => '15',
            'page' => '2',
            'par_page' => '50',
        ], $this->lastQuery());
    }

    public function testSuggerer(): void
    {
        $this->http->willRespondWithFixture('suggestions.json');

        $suggestions = $this->client->entreprises()->suggest('gain', 2);

        self::assertSame(['query' => 'gain', 'limit' => '2'], $this->lastQuery());
        self::assertCount(2, $suggestions);
        self::assertSame('gain-emile-s-a-r-l-097380463', $suggestions[1]->slug);
        self::assertTrue($suggestions[1]->active);
    }
}
