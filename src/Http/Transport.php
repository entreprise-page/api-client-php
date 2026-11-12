<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Http;

use EntreprisePage\ApiClient\Exception\ApiException;
use EntreprisePage\ApiClient\Exception\TransportException;
use EntreprisePage\ApiClient\Hydration\Data;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

/**
 * Envoie les requêtes à l'API et décode les réponses.
 *
 * @internal
 */
final class Transport
{
    private ClientInterface $httpClient;
    private RequestFactoryInterface $requestFactory;
    private StreamFactoryInterface $streamFactory;
    private string $baseUri;
    private ?string $apiKey;
    private string $userAgent;

    public function __construct(
        ClientInterface $httpClient,
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface $streamFactory,
        string $baseUri,
        ?string $apiKey,
        string $userAgent
    ) {
        $this->httpClient = $httpClient;
        $this->requestFactory = $requestFactory;
        $this->streamFactory = $streamFactory;
        $this->baseUri = $baseUri;
        $this->apiKey = $apiKey;
        $this->userAgent = $userAgent;
    }

    /**
     * @param array<string, string> $query
     *
     * @return array<mixed>
     */
    public function get(string $path, array $query = []): array
    {
        return Data::decode($this->send('GET', $path, $query));
    }

    /**
     * Envoie un corps JSON et décode la réponse.
     *
     * @param array<string, mixed>|null $body
     *
     * @return array<mixed>
     */
    public function post(string $path, ?array $body = null): array
    {
        return Data::decode($this->send('POST', $path, [], $body));
    }

    /**
     * Envoie un corps JSON sans attendre de contenu en retour (204).
     *
     * @param array<string, mixed>|null $body
     */
    public function postWithoutContent(string $path, ?array $body = null): void
    {
        $this->send('POST', $path, [], $body);
    }

    /**
     * @param array<string, mixed> $body
     *
     * @return array<mixed>
     */
    public function put(string $path, array $body): array
    {
        return Data::decode($this->send('PUT', $path, [], $body));
    }

    public function delete(string $path): void
    {
        $this->send('DELETE', $path);
    }

    /**
     * Encode un segment de chemin (siren, siret, code…).
     *
     * @param string|int $value
     */
    public static function segment($value): string
    {
        return rawurlencode((string) $value);
    }

    /**
     * @param array<string, string>     $query
     * @param array<string, mixed>|null $body
     *
     * @return string le corps de la réponse
     */
    private function send(string $method, string $path, array $query = [], ?array $body = null): string
    {
        $uri = rtrim($this->baseUri, '/').$path;
        if ([] !== $query) {
            $uri .= '?'.http_build_query($query, '', '&', \PHP_QUERY_RFC3986);
        }

        $request = $this->requestFactory->createRequest($method, $uri)
            ->withHeader('Accept', 'application/json')
            ->withHeader('User-Agent', $this->userAgent);

        if (null !== $this->apiKey) {
            $request = $request->withHeader('X-API-Key', $this->apiKey);
        }

        if (null !== $body) {
            $request = $request
                ->withHeader('Content-Type', 'application/json')
                ->withBody($this->streamFactory->createStream(json_encode($body, \JSON_THROW_ON_ERROR | \JSON_UNESCAPED_UNICODE | \JSON_UNESCAPED_SLASHES)));
        }

        try {
            $response = $this->httpClient->sendRequest($request);
        } catch (ClientExceptionInterface $e) {
            throw new TransportException(\sprintf('Échec de la requête %s %s : %s', $method, $path, $e->getMessage()), 0, $e);
        }

        if ($response->getStatusCode() >= 400) {
            throw ApiException::fromResponse($response);
        }

        return (string) $response->getBody();
    }
}
