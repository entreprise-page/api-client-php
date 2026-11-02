<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Tests\Query;

use EntreprisePage\ApiClient\Exception\InvalidArgumentException;
use EntreprisePage\ApiClient\Query\RechercheActiviteQuery;
use EntreprisePage\ApiClient\Query\RechercheEntrepriseQuery;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class QueryValidationTest extends TestCase
{
    /**
     * @param \Closure(): object $create
     */
    #[DataProvider('criteresInvalides')]
    public function testRefuseLesCriteresInvalides(\Closure $create, string $message): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($message);

        $create();
    }

    /**
     * @return iterable<string, array{\Closure(): object, string}>
     */
    public static function criteresInvalides(): iterable
    {
        yield 'latitude seule' => [static fn () => new RechercheEntrepriseQuery('a', latitude: 45.0), 'latitude et longitude'];
        yield 'rayon sans point' => [static fn () => new RechercheEntrepriseQuery('a', rayon: 10), 'rayon n\'a de sens'];
        yield 'rayon trop grand' => [static fn () => new RechercheEntrepriseQuery('a', latitude: 45.0, longitude: 4.0, rayon: 501), 'entre 1 et 500'];
        yield 'par page entreprise' => [static fn () => new RechercheEntrepriseQuery('a', parPage: 251), 'entre 1 et 250'];
        yield 'page nulle' => [static fn () => new RechercheEntrepriseQuery('a', page: 0), 'supérieure ou égale à 1'];
        yield 'activité vide' => [static fn () => new RechercheActiviteQuery('  '), 'query est obligatoire'];
        yield 'par page activité' => [static fn () => new RechercheActiviteQuery('plombier', parPage: 101), 'entre 1 et 100'];
    }

    public function testOmetLesCriteresNonRenseignes(): void
    {
        self::assertSame(['query' => 'google'], (new RechercheEntrepriseQuery('google'))->toQuery());
    }
}
