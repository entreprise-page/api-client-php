<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Tests;

use Nyholm\Psr7\Response;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Client PSR-18 qui renvoie des réponses préparées et garde les requêtes envoyées.
 */
final class FakeHttpClient implements ClientInterface
{
    /** @var list<RequestInterface> */
    public array $requests = [];

    /** @var list<ResponseInterface|ClientExceptionInterface> */
    private array $queue = [];

    public function willRespond(int $status, string $body): self
    {
        $this->queue[] = new Response($status, ['Content-Type' => 'application/json'], $body);

        return $this;
    }

    public function willRespondWithFixture(string $fixture): self
    {
        return $this->willRespond(200, (string) file_get_contents(__DIR__.'/Fixtures/'.$fixture));
    }

    public function willFail(ClientExceptionInterface $exception): self
    {
        $this->queue[] = $exception;

        return $this;
    }

    public function lastRequest(): RequestInterface
    {
        return $this->requests[\count($this->requests) - 1] ?? throw new \LogicException('Aucune requête envoyée.');
    }

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $this->requests[] = $request;
        $next = array_shift($this->queue) ?? throw new \LogicException('Aucune réponse préparée pour '.$request->getUri());

        return $next instanceof ResponseInterface ? $next : throw $next;
    }
}
