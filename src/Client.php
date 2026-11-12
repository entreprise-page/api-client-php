<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient;

use EntreprisePage\ApiClient\Api\ActiviteApi;
use EntreprisePage\ApiClient\Api\AnnonceApi;
use EntreprisePage\ApiClient\Api\CompteApi;
use EntreprisePage\ApiClient\Api\ConventionCollectiveApi;
use EntreprisePage\ApiClient\Api\EntrepriseApi;
use EntreprisePage\ApiClient\Api\EtablissementApi;
use EntreprisePage\ApiClient\Api\FormeJuridiqueApi;
use EntreprisePage\ApiClient\Api\SuiviApi;
use EntreprisePage\ApiClient\Http\Transport;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

/**
 * Point d'entrée du SDK de l'API entreprise.page.
 *
 * Le client HTTP est n'importe quelle implémentation PSR-18 (Symfony HttpClient,
 * Guzzle…) : il peut être décoré pour ajouter du cache, des retries ou des logs.
 * S'il n'est pas fourni, une implémentation installée est découverte automatiquement,
 * comme les fabriques PSR-17.
 */
final class Client
{
    public const DEFAULT_BASE_URI = 'https://api.entreprise.page/v1';
    public const USER_AGENT = 'entreprise-page-api-client-php';

    private Transport $transport;

    private ?EntrepriseApi $entreprises = null;
    private ?EtablissementApi $etablissements = null;
    private ?AnnonceApi $annonces = null;
    private ?ActiviteApi $activites = null;
    private ?ConventionCollectiveApi $conventionsCollectives = null;
    private ?FormeJuridiqueApi $formesJuridiques = null;
    private ?CompteApi $compte = null;
    private ?SuiviApi $suivi = null;

    /**
     * @param string|null                 $apiKey        clé envoyée dans l'en-tête X-API-Key, obligatoire pour les endpoints `organisation`, `quota` et `suivi`
     * @param StreamFactoryInterface|null $streamFactory fabrique des corps de requête JSON ; par défaut $requestFactory s'il l'implémente (Nyholm, Guzzle, Symfony Psr18Client), sinon découverte
     */
    public function __construct(
        ?string $apiKey = null,
        ?ClientInterface $httpClient = null,
        ?RequestFactoryInterface $requestFactory = null,
        string $baseUri = self::DEFAULT_BASE_URI,
        string $userAgent = self::USER_AGENT,
        ?StreamFactoryInterface $streamFactory = null
    ) {
        $requestFactory ??= Psr17FactoryDiscovery::findRequestFactory();
        if (null === $streamFactory) {
            $streamFactory = $requestFactory instanceof StreamFactoryInterface ? $requestFactory : Psr17FactoryDiscovery::findStreamFactory();
        }

        $this->transport = new Transport(
            $httpClient ?? Psr18ClientDiscovery::find(),
            $requestFactory,
            $streamFactory,
            $baseUri,
            $apiKey,
            $userAgent,
        );
    }

    public function entreprises(): EntrepriseApi
    {
        return $this->entreprises ??= new EntrepriseApi($this->transport);
    }

    public function etablissements(): EtablissementApi
    {
        return $this->etablissements ??= new EtablissementApi($this->transport);
    }

    public function annonces(): AnnonceApi
    {
        return $this->annonces ??= new AnnonceApi($this->transport);
    }

    public function activites(): ActiviteApi
    {
        return $this->activites ??= new ActiviteApi($this->transport);
    }

    public function conventionsCollectives(): ConventionCollectiveApi
    {
        return $this->conventionsCollectives ??= new ConventionCollectiveApi($this->transport);
    }

    public function formesJuridiques(): FormeJuridiqueApi
    {
        return $this->formesJuridiques ??= new FormeJuridiqueApi($this->transport);
    }

    public function compte(): CompteApi
    {
        return $this->compte ??= new CompteApi($this->transport);
    }

    /**
     * Listes de suivi, entreprises suivies et alertes de l'organisation de la clé d'API.
     */
    public function suivi(): SuiviApi
    {
        return $this->suivi ??= new SuiviApi($this->transport);
    }
}
