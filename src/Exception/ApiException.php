<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Exception;

use Psr\Http\Message\ResponseInterface;

/**
 * L'API a répondu avec un statut d'erreur (4xx ou 5xx).
 */
class ApiException extends \RuntimeException implements ExceptionInterface
{
    /** @var ResponseInterface */
    private $response;

    public function __construct(string $message, ResponseInterface $response, ?\Throwable $previous = null)
    {
        parent::__construct($message, $response->getStatusCode(), $previous);
        $this->response = $response;
    }

    public static function fromResponse(ResponseInterface $response): self
    {
        $message = self::extractMessage($response);
        $status = $response->getStatusCode();

        if (400 === $status) {
            return new BadRequestException($message, $response);
        }
        if (401 === $status || 403 === $status) {
            return new UnauthorizedException($message, $response);
        }
        if (404 === $status) {
            return new NotFoundException($message, $response);
        }
        if (429 === $status) {
            return new TooManyRequestsException($message, $response);
        }
        if ($status >= 500) {
            return new ServerException($message, $response);
        }

        return new self($message, $response);
    }

    public function getStatusCode(): int
    {
        return $this->response->getStatusCode();
    }

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }

    /**
     * L'API renvoie soit une chaîne JSON (`"message"`), soit un objet `{"error": "message"}`.
     */
    private static function extractMessage(ResponseInterface $response): string
    {
        $body = (string) $response->getBody();
        $fallback = \sprintf('L\'API a répondu %d %s', $response->getStatusCode(), $response->getReasonPhrase());

        try {
            $decoded = json_decode($body, true, 512, \JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            return '' !== trim($body) ? trim($body) : $fallback;
        }

        if (\is_string($decoded) && '' !== $decoded) {
            return $decoded;
        }
        if (\is_array($decoded) && \is_string($decoded['error'] ?? null)) {
            return $decoded['error'];
        }

        return $fallback;
    }
}
