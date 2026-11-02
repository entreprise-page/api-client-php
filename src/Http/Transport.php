<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Http;

use EntreprisePage\ApiClient\Exception\ApiException;
use EntreprisePage\ApiClient\Exception\TransportException;
use EntreprisePage\ApiClient\Hydration\Data;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;

/**
 * Envoie les requêtes à l'API et décode les réponses.
 *
 * @internal
 */
final readonly class Transport
{
    public function __construct(
        private ClientInterface $httpClient,
        private RequestFactoryInterface $requestFactory,
        private string $baseUri,
        private ?string $apiKey,
        private string $userAgent,
    ) {
    }

    /**
     * @param array<string, string> $query
     *
     * @return array<mixed>
     */
    public function get(string $path, array $query = []): array
    {
        $uri = rtrim($this->baseUri, '/').$path;
        if ([] !== $query) {
            $uri .= '?'.http_build_query($query, '', '&', \PHP_QUERY_RFC3986);
        }

        $request = $this->requestFactory->createRequest('GET', $uri)
            ->withHeader('Accept', 'application/json')
            ->withHeader('User-Agent', $this->userAgent);

        if (null !== $this->apiKey) {
            $request = $request->withHeader('X-API-Key', $this->apiKey);
        }

        try {
            $response = $this->httpClient->sendRequest($request);
        } catch (ClientExceptionInterface $e) {
            throw new TransportException(\sprintf('Échec de la requête GET %s : %s', $path, $e->getMessage()), 0, $e);
        }

        if ($response->getStatusCode() >= 400) {
            throw ApiException::fromResponse($response);
        }

        return Data::decode((string) $response->getBody());
    }

    /**
     * Encode un segment de chemin (siren, siret, code…).
     */
    public static function segment(string $value): string
    {
        return rawurlencode($value);
    }
}
