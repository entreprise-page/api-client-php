# entreprise-page/api-client

Client PHP de l'[API entreprise.page](https://api.entreprise.page/v1), construit à partir du swagger de l'API (`api/docs/swagger.json`).

- PHP 8.2 ou plus.
- Client HTTP au choix : n'importe quelle implémentation [PSR-18](https://www.php-fig.org/psr/psr-18/) (Symfony HttpClient, Guzzle…) et une fabrique de requêtes [PSR-17](https://www.php-fig.org/psr/psr-17/).
- Réponses hydratées dans des objets `readonly` typés (`EntreprisePage\ApiClient\Model`).

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

$entreprise = $client->entreprises()->recuperer('443061841');
echo $entreprise->denominationSociale;

$codes = array_map(
    static fn ($activite) => $activite->code,
    $client->activites()->rechercher('plombier')->resultats,
);

$resultats = $client->entreprises()->rechercher(new RechercheEntrepriseQuery(
    query: '*',
    activites: $codes,
    actif: true,
    latitude: 45.7672724,
    longitude: 4.8340594,
    rayon: 10,
    parPage: 50,
));
```

| Méthode | Endpoint | Clé d'API |
| --- | --- | --- |
| `entreprises()->recuperer($siren)` | `GET /organisation/entreprise/{siren}` | oui |
| `entreprises()->rechercher($query)` | `GET /organisation/recherche` | oui |
| `entreprises()->suggerer($query, $limit)` | `GET /organisation/suggestion` | non |
| `etablissements()->recuperer($siret)` | `GET /organisation/etablissement/{siret}` | oui |
| `etablissements()->listerParSiren($siren, $filtres)` | `GET /organisation/entreprise/{siren}/etablissement` | oui |
| `annonces()->listerParSiren($siren)` | `GET /organisation/entreprise/{siren}/annonce` | oui |
| `activites()->lister()` / `recuperer($code)` | `GET /dictionnaire/activite[/{code}]` | non |
| `activites()->rechercher($query)` | `GET /dictionnaire/recherche/activite` | non |
| `conventionsCollectives()->lister()` / `recuperer($idcc)` | `GET /dictionnaire/convention-collective[/{code}]` | non |
| `formesJuridiques()->lister()` / `recuperer($code)` | `GET /dictionnaire/forme-juridique[/{code}]` | non |
| `compte()->quota()` | `GET /quota` | oui |

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

## Développement

```bash
composer install
composer test
composer phpstan
```

Les modèles de `src/Model` sont générés depuis le swagger : après une modification des DTO Go et un `swag init`, lancer `composer generate`. Le test `GeneratedModelsTest` échoue tant que les modèles ne sont pas à jour. Les endpoints (`src/Api`) sont écrits à la main, car le swagger ne décrit pas toujours fidèlement les réponses (par exemple `/organisation/recherche` y est annoncé comme une liste alors que l'API renvoie un objet).
