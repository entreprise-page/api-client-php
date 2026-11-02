<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Query;

use EntreprisePage\ApiClient\Exception\InvalidArgumentException;

/**
 * Critères de GET /organisation/recherche.
 *
 * Immuable : chaque méthode with…() renvoie une copie.
 *
 *     RechercheEntrepriseQuery::create('plombier')
 *         ->withActivites(['43.22A'])
 *         ->withZone(45.7672724, 4.8340594, 10)
 *         ->withParPage(50);
 */
final class RechercheEntrepriseQuery
{
    private string $query;

    /** @var list<string> */
    private array $activites = [];

    /** @var list<int> */
    private array $categoriesJuridiques = [];

    private ?bool $actif = null;
    private ?float $latitude = null;
    private ?float $longitude = null;
    private ?int $rayon = null;
    private ?int $page = null;
    private ?int $parPage = null;

    private function __construct(string $query)
    {
        $this->query = $query;
    }

    public static function create(string $query): self
    {
        return new self($query);
    }

    /**
     * @param list<string> $codes codes NAF, par exemple ceux renvoyés par ActiviteApi::search()
     */
    public function withActivites(array $codes): self
    {
        $clone = clone $this;
        $clone->activites = $codes;

        return $clone;
    }

    /**
     * @param list<int> $codes codes de catégorie juridique
     */
    public function withCategoriesJuridiques(array $codes): self
    {
        $clone = clone $this;
        $clone->categoriesJuridiques = $codes;

        return $clone;
    }

    /**
     * @param bool $actif true pour les entreprises en activité, false pour les cessées
     */
    public function withActif(bool $actif): self
    {
        $clone = clone $this;
        $clone->actif = $actif;

        return $clone;
    }

    /**
     * @param int|null $rayon en kilomètres, de 1 à 500 (20 par défaut côté API)
     */
    public function withZone(float $latitude, float $longitude, ?int $rayon = null): self
    {
        if (null !== $rayon && ($rayon < 1 || $rayon > 500)) {
            throw new InvalidArgumentException('rayon doit être compris entre 1 et 500 km.');
        }

        $clone = clone $this;
        $clone->latitude = $latitude;
        $clone->longitude = $longitude;
        $clone->rayon = $rayon;

        return $clone;
    }

    public function withPage(int $page): self
    {
        if ($page < 1) {
            throw new InvalidArgumentException('page doit être supérieure ou égale à 1.');
        }

        $clone = clone $this;
        $clone->page = $page;

        return $clone;
    }

    /**
     * @param int $parPage de 1 à 250
     */
    public function withParPage(int $parPage): self
    {
        if ($parPage < 1 || $parPage > 250) {
            throw new InvalidArgumentException('parPage doit être compris entre 1 et 250.');
        }

        $clone = clone $this;
        $clone->parPage = $parPage;

        return $clone;
    }

    /**
     * @return array<string, string>
     */
    public function toQuery(): array
    {
        return QueryValue::filter([
            'query' => $this->query,
            'activite' => implode(',', $this->activites),
            'categorie_juridique' => implode(',', $this->categoriesJuridiques),
            'actif' => QueryValue::bool($this->actif),
            'latitude' => QueryValue::float($this->latitude),
            'longitude' => QueryValue::float($this->longitude),
            'rayon' => QueryValue::int($this->rayon),
            'page' => QueryValue::int($this->page),
            'par_page' => QueryValue::int($this->parPage),
        ]);
    }
}
