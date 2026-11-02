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
     * @dataProvider criteresInvalides
     *
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
        yield 'rayon trop petit' => [static fn () => RechercheEntrepriseQuery::create('a')->withZone(45.0, 4.0, 0), 'entre 1 et 500'];
        yield 'rayon trop grand' => [static fn () => RechercheEntrepriseQuery::create('a')->withZone(45.0, 4.0, 501), 'entre 1 et 500'];
        yield 'par page entreprise' => [static fn () => RechercheEntrepriseQuery::create('a')->withParPage(251), 'entre 1 et 250'];
        yield 'page nulle' => [static fn () => RechercheEntrepriseQuery::create('a')->withPage(0), 'supérieure ou égale à 1'];
        yield 'activité vide' => [static fn () => RechercheActiviteQuery::create('  '), 'query est obligatoire'];
        yield 'par page activité' => [static fn () => RechercheActiviteQuery::create('plombier')->withParPage(101), 'entre 1 et 100'];
    }

    public function testOmetLesCriteresNonRenseignes(): void
    {
        self::assertSame(['query' => 'google'], RechercheEntrepriseQuery::create('google')->toQuery());
    }

    public function testLesWithRenvoientUneCopie(): void
    {
        $base = RechercheEntrepriseQuery::create('google');
        $paginee = $base->withPage(3);

        self::assertSame(['query' => 'google'], $base->toQuery());
        self::assertSame(['query' => 'google', 'page' => '3'], $paginee->toQuery());
    }

    public function testFormateLesFlottantsSansDependreDeLaLocale(): void
    {
        $locale = setlocale(\LC_NUMERIC, '0');
        setlocale(\LC_NUMERIC, 'fr_FR.UTF-8', 'fr_FR', 'de_DE.UTF-8');

        try {
            $query = RechercheEntrepriseQuery::create('a')->withZone(45.5, 4.25)->toQuery();
        } finally {
            setlocale(\LC_NUMERIC, (string) $locale);
        }

        self::assertSame('45.5', $query['latitude']);
        self::assertSame('4.25', $query['longitude']);
    }
}
