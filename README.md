# entreprise-page/api-client

Client PHP de l'[API entreprise.page](https://api.entreprise.page/v1), construit à partir du swagger de l'API (`api/docs/swagger.json`).

- PHP 7.4 ou plus (testé de 7.4 à 8.5).
- Client HTTP au choix : n'importe quelle implémentation [PSR-18](https://www.php-fig.org/psr/psr-18/) (Symfony HttpClient, Guzzle…) et une fabrique de requêtes [PSR-17](https://www.php-fig.org/psr/psr-17/).
- Réponses hydratées dans des objets typés (`EntreprisePage\ApiClient\Model`). PHP 7.4 n'ayant pas de propriétés `readonly`, leurs propriétés publiques sont marquées `@readonly` : PHPStan et Psalm signalent toute modification.

## Installation

```bash
composer require entreprise-page/api-client symfony/http-client nyholm/psr7
```

N'importe quel couple PSR-18 / PSR-17 convient à la place de `symfony/http-client` et `nyholm/psr7`.

## Utilisation

```php
use EntreprisePage\ApiClient\Client;
use EntreprisePage\ApiClient\Query\RechercheEntrepriseQuery;

// Le client HTTP et la fabrique de requêtes sont découverts automatiquement s'ils ne sont pas fournis.
$client = new Client('votre-cle-api');

$entreprise = $client->entreprises()->get('443061841');
echo $entreprise->denominationSociale;

$codes = array_map(
    static fn ($activite) => $activite->code,
    $client->activites()->search('plombier')->resultats,
);

// Les critères sont immuables : chaque with…() renvoie une copie.
$resultats = $client->entreprises()->search(
    RechercheEntrepriseQuery::create('*')
        ->withActivites($codes)
        ->withActif(true)
        ->withZone(45.7672724, 4.8340594, 10)
        ->withParPage(50)
);

// Plutôt qu'une zone autour d'un point : départements, région ou codes postaux.
$lyonnais = $client->entreprises()->search(
    RechercheEntrepriseQuery::create('*')
        ->withActivites($codes)
        ->withDepartements(['69'])
        ->withCodesPostaux(['69250'])
);

// Le statut détaille est_actif : actif, inactif, ferme ou cessee, avec la date de cessation.
echo $entreprise->meta->statut->code, ' ', $entreprise->meta->statut->date ?? '';
```

| Méthode | Endpoint | Clé d'API |
| --- | --- | --- |
| `entreprises()->get($siren)` | `GET /organisation/entreprise/{siren}` | oui |
| `entreprises()->search($query)` | `GET /organisation/recherche` | oui |
| `entreprises()->suggest($query, $limit)` | `GET /organisation/suggestion` | non |
| `etablissements()->get($siret)` | `GET /organisation/etablissement/{siret}` | oui |
| `etablissements()->listBySiren($siren, $filtres)` | `GET /organisation/entreprise/{siren}/etablissement` | oui |
| `annonces()->listBySiren($siren)` | `GET /organisation/entreprise/{siren}/annonce` | oui |
| `activites()->list()` / `get($code)` | `GET /dictionnaire/activite[/{code}]` | non |
| `activites()->search($query)` | `GET /dictionnaire/recherche/activite` | oui |
| `conventionsCollectives()->list()` / `get($idcc)` | `GET /dictionnaire/convention-collective[/{code}]` | non |
| `formesJuridiques()->list()` / `get($code)` | `GET /dictionnaire/forme-juridique[/{code}]` | non |
| `compte()->quota()` | `GET /quota` | oui |
| `suivi()->lists()` / `createList($nom)` / `deleteList($listeId)` | `GET` / `POST /suivi/liste`, `DELETE /suivi/liste/{listeId}` | oui |
| `suivi()->companies($listeId, $page, $parPage)` | `GET /suivi/entreprise` | oui |
| `suivi()->isFollowed($siren)` / `unfollow($siren)` | `GET` / `DELETE /suivi/entreprise/{siren}` | oui |
| `suivi()->follow($listeId, $siren)` / `removeFromList($listeId, $siren)` | `POST /suivi/liste/{listeId}/entreprise`, `DELETE …/entreprise/{siren}` | oui |
| `suivi()->import($listeId, $sirens)` | `POST /suivi/liste/{listeId}/import` | oui |
| `suivi()->alert($listeId)` / `configureAlert($listeId, $alerte)` | `GET` / `PUT /suivi/liste/{listeId}/alerte` | oui |
| `suivi()->enableAlert($listeId)` / `disableAlert($listeId)` | `POST /suivi/liste/{listeId}/alerte/activer` / `desactiver` | oui |

### Suivi d'entreprises

Les endpoints `suivi()` agissent sur les listes de suivi de l'organisation rattachée à la clé d'API, sans consommer le quota.

```php
use EntreprisePage\ApiClient\Model\SuiviConfigurationAlerte;
use EntreprisePage\ApiClient\Model\SuiviConfigurationAlerteEmail;
use EntreprisePage\ApiClient\Model\SuiviConfigurationAlerteWebhook;

$liste = $client->suivi()->createList('Fournisseurs');
$client->suivi()->follow($liste->id, '552032534');

// Un siren invalide ou introuvable compte comme une erreur sans interrompre l'import.
$statut = $client->suivi()->import($liste->id, ['542051180', '443061841']);

foreach ($client->suivi()->companies($liste->id)->entreprises as $entreprise) {
    echo $entreprise->siren, ' ', $entreprise->denomination ?? '(non diffusable)', "\n";
}

// Remplace toute l'alerte : les événements possibles sont dans alert($id)->evenementsDisponibles.
$client->suivi()->configureAlert($liste->id, new SuiviConfigurationAlerte(
    true,
    new SuiviConfigurationAlerteEmail(true, ['veille@exemple.fr']),
    ['fermeture_entreprise', 'changement_denomination'],
    new SuiviConfigurationAlerteWebhook(false, '', ''), // actif, token, url
));
```

### Erreurs

Toutes les exceptions implémentent `EntreprisePage\ApiClient\Exception\ExceptionInterface`.

| Exception | Cas |
| --- | --- |
| `BadRequestException`, `UnauthorizedException`, `NotFoundException`, `TooManyRequestsException`, `ServerException` | statut HTTP 400, 401/403, 404, 429, 5xx ; toutes étendent `ApiException`, qui donne accès à la réponse PSR-7 |
| `TransportException` | aucune réponse reçue (réseau, timeout) |
| `UnexpectedResponseException` | réponse qui ne respecte pas le contrat (JSON invalide, champ manquant ou mal typé) |
| `InvalidArgumentException` | critères de recherche invalides, détectés avant l'envoi |

## Intégration Symfony

Le constructeur ne prend que des interfaces PSR : le client se déclare comme un service ordinaire, avec le client HTTP du framework (qui peut être décoré pour le cache, les retries ou les logs).

```yaml
# config/services.yaml
services:
    entreprise_page.http_client:
        class: Symfony\Component\HttpClient\Psr18Client
        arguments: ['@http_client']

    EntreprisePage\ApiClient\Client:
        arguments:
            $apiKey: '%env(ENTREPRISE_PAGE_API_KEY)%'
            $httpClient: '@entreprise_page.http_client'
            $requestFactory: '@entreprise_page.http_client'
```