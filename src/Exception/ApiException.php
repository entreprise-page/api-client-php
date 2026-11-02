<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Exception;

use Psr\Http\Message\ResponseInterface;

/**
 * L'API a répondu avec un statut d'erreur (4xx ou 5xx).
 */
class ApiException extends \RuntimeException implements ExceptionInterface
{
    public function __construct(
        string $message,
        private readonly ResponseInterface $response,
        ?\Throwable $previous = null,
    ) {
        parent::__construct($message, $response->getStatusCode(), $previous);
    }

    public static function fromResponse(ResponseInterface $response): self
    {
        $message = self::extractMessage($response);

        return match (true) {
            400 === $response->getStatusCode() => new BadRequestException($message, $response),
            401 === $response->getStatusCode(), 403 === $response->getStatusCode() => new UnauthorizedException($message, $response),
            404 === $response->getStatusCode() => new NotFoundException($message, $response),
            429 === $response->getStatusCode() => new TooManyRequestsException($message, $response),
            $response->getStatusCode() >= 500 => new ServerException($message, $response),
            default => new self($message, $response),
        };
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
        } catch (\JsonException) {
            return '' !== trim($body) ? trim($body) : $fallback;
        }

        return match (true) {
            \is_string($decoded) && '' !== $decoded => $decoded,
            \is_array($decoded) && \is_string($decoded['error'] ?? null) => $decoded['error'],
            default => $fallback,
        };
    }
}
