<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Tests;

use EntreprisePage\ApiClient\Client;
use EntreprisePage\ApiClient\Exception\ApiException;
use EntreprisePage\ApiClient\Exception\BadRequestException;
use EntreprisePage\ApiClient\Exception\ExceptionInterface;
use EntreprisePage\ApiClient\Exception\NotFoundException;
use EntreprisePage\ApiClient\Exception\ServerException;
use EntreprisePage\ApiClient\Exception\TooManyRequestsException;
use EntreprisePage\ApiClient\Exception\TransportException;
use EntreprisePage\ApiClient\Exception\UnauthorizedException;
use EntreprisePage\ApiClient\Exception\UnexpectedResponseException;
use Nyholm\Psr7\Factory\Psr17Factory;
use PHPUnit\Framework\Attributes\DataProvider;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;

final class ClientTest extends ApiTestCase
{
    public function testEnvoieLesEnTetes(): void
    {
        $this->http->willRespond(200, '{"total":0,"max":10}');

        $this->client->compte()->quota();

        $request = $this->http->lastRequest();
        self::assertSame('GET', $request->getMethod());
        self::assertSame('cle-de-test', $request->getHeaderLine('X-API-Key'));
        self::assertSame('application/json', $request->getHeaderLine('Accept'));
        self::assertSame(Client::USER_AGENT, $request->getHeaderLine('User-Agent'));
    }

    public function testNEnvoiePasDeCleQuandElleNEstPasFournie(): void
    {
        $http = (new FakeHttpClient())->willRespond(200, '[]');

        (new Client(null, $http, new Psr17Factory()))->entreprises()->suggest('google');

        self::assertFalse($http->lastRequest()->hasHeader('X-API-Key'));
        self::assertSame('https://api.entreprise.page/v1/organisation/suggestion?query=google', (string) $http->lastRequest()->getUri());
    }

    public function testEncodeLesSegmentsDeChemin(): void
    {
        $this->http->willRespond(404, '"entreprise introuvable"');

        try {
            $this->client->entreprises()->get('../quota?x=1');
        } catch (NotFoundException $e) {
        }

        self::assertSame('/v1/organisation/entreprise/..%2Fquota%3Fx%3D1', $this->http->lastRequest()->getUri()->getPath());
    }

    /**
     * @dataProvider erreurs
     *
     * @param class-string<ApiException> $exception
     */
    #[DataProvider('erreurs')]
    public function testConvertitLesErreursHttp(int $status, string $body, string $exception, string $message): void
    {
        $this->http->willRespond($status, $body);

        try {
            $this->client->entreprises()->get('000000000');
            self::fail('Une exception était attendue.');
        } catch (ApiException $e) {
            self::assertInstanceOf($exception, $e);
            self::assertInstanceOf(ExceptionInterface::class, $e);
            self::assertSame($message, $e->getMessage());
            self::assertSame($status, $e->getStatusCode());
            self::assertSame($body, (string) $e->getResponse()->getBody());
        }
    }

    /**
     * @return iterable<string, array{int, string, class-string<ApiException>, string}>
     */
    public static function erreurs(): iterable
    {
        yield 'chaîne JSON' => [404, '"entreprise 000000000 introuvable"', NotFoundException::class, 'entreprise 000000000 introuvable'];
        yield 'objet error' => [401, '{"error":"Clé d\'API inconnue"}', UnauthorizedException::class, 'Clé d\'API inconnue'];
        yield 'objet erreur du suivi' => [404, '{"erreur":"Liste introuvable"}', NotFoundException::class, 'Liste introuvable'];
        yield 'quota' => [429, '{"error":"Quota dépassé"}', TooManyRequestsException::class, 'Quota dépassé'];
        yield 'requête invalide' => [400, '"le paramètre query est obligatoire"', BadRequestException::class, 'le paramètre query est obligatoire'];
        yield 'corps non JSON' => [502, 'Bad Gateway', ServerException::class, 'Bad Gateway'];
        yield 'corps vide' => [500, '', ServerException::class, 'L\'API a répondu 500 Internal Server Error'];
        yield 'statut non mappé' => [418, '{}', ApiException::class, 'L\'API a répondu 418 I\'m a teapot'];
    }

    public function testConvertitLesErreursReseau(): void
    {
        $this->http->willFail(new class('Connexion refusée') extends \RuntimeException implements ClientExceptionInterface {});

        $this->expectException(TransportException::class);
        $this->expectExceptionMessage('Échec de la requête GET /quota : Connexion refusée');

        $this->client->compte()->quota();
    }

    public function testSignaleUnJsonInvalide(): void
    {
        $this->http->willRespond(200, '<html>');

        $this->expectException(UnexpectedResponseException::class);

        $this->client->compte()->quota();
    }

    public function testSignaleUnChampMalType(): void
    {
        $this->http->willRespond(200, '{"total":"12","max":1000}');

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage('Le champ "total" devrait être de type int, string reçu.');

        $this->client->compte()->quota();
    }

    public function testConvertitLesErreursReseauAvecLaMethode(): void
    {
        $this->http->willFail(new class('Connexion refusée') extends \RuntimeException implements ClientExceptionInterface {});

        $this->expectException(TransportException::class);
        $this->expectExceptionMessage('Échec de la requête DELETE /suivi/entreprise/552032534 : Connexion refusée');

        $this->client->suivi()->unfollow('552032534');
    }

    public function testUtiliseLaFabriqueDeFluxFournie(): void
    {
        $http = (new FakeHttpClient())->willRespond(204, '');
        $factory = new Psr17Factory();
        $streams = new class($factory) implements StreamFactoryInterface {
            public int $calls = 0;
            private Psr17Factory $factory;

            public function __construct(Psr17Factory $factory)
            {
                $this->factory = $factory;
            }

            public function createStream(string $content = ''): StreamInterface
            {
                ++$this->calls;

                return $this->factory->createStream($content);
            }

            public function createStreamFromFile(string $filename, string $mode = 'r'): StreamInterface
            {
                return $this->factory->createStreamFromFile($filename, $mode);
            }

            public function createStreamFromResource($resource): StreamInterface
            {
                return $this->factory->createStreamFromResource($resource);
            }
        };

        (new Client('cle', $http, $factory, Client::DEFAULT_BASE_URI, Client::USER_AGENT, $streams))->suivi()->follow(1, '552032534');

        self::assertSame(1, $streams->calls);
        self::assertSame('{"siren":"552032534"}', (string) $http->lastRequest()->getBody());
    }

    public function testDecouvreUneImplementationPsr18InstalleeParDefaut(): void
    {
        self::assertInstanceOf(Client::class, new Client('cle'));
    }
}
