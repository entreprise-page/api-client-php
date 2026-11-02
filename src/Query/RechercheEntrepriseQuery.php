<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Query;

use EntreprisePage\ApiClient\Exception\InvalidArgumentException;

/**
 * Critères de GET /organisation/recherche.
 */
final readonly class RechercheEntrepriseQuery
{
    /**
     * @param list<string> $activites            codes NAF, par exemple ceux renvoyés par la recherche d'activité
     * @param list<int>    $categoriesJuridiques codes de catégorie juridique
     * @param bool|null    $actif                true pour les entreprises en activité, false pour les cessées
     * @param int|null     $rayon                rayon en kilomètres autour de latitude/longitude (1 à 500, 20 par défaut côté API)
     * @param int|null     $parPage              1 à 250
     */
    public function __construct(
        public string $query,
        public array $activites = [],
        public array $categoriesJuridiques = [],
        public ?bool $actif = null,
        public ?float $latitude = null,
        public ?float $longitude = null,
        public ?int $rayon = null,
        public ?int $page = null,
        public ?int $parPage = null,
    ) {
        if ((null === $latitude) !== (null === $longitude)) {
            throw new InvalidArgumentException('latitude et longitude doivent être renseignées ensemble.');
        }
        if (null !== $rayon && ($rayon < 1 || $rayon > 500)) {
            throw new InvalidArgumentException('rayon doit être compris entre 1 et 500 km.');
        }
        if (null !== $rayon && null === $latitude) {
            throw new InvalidArgumentException('rayon n\'a de sens qu\'avec latitude et longitude.');
        }
        if (null !== $page && $page < 1) {
            throw new InvalidArgumentException('page doit être supérieure ou égale à 1.');
        }
        if (null !== $parPage && ($parPage < 1 || $parPage > 250)) {
            throw new InvalidArgumentException('parPage doit être compris entre 1 et 250.');
        }
    }

    /**
     * @return array<string, string>
     */
    public function toQuery(): array
    {
        return array_filter([
            'query' => $this->query,
            'activite' => implode(',', $this->activites),
            'categorie_juridique' => implode(',', $this->categoriesJuridiques),
            'actif' => QueryValue::bool($this->actif),
            'latitude' => QueryValue::float($this->latitude),
            'longitude' => QueryValue::float($this->longitude),
            'rayon' => QueryValue::int($this->rayon),
            'page' => QueryValue::int($this->page),
            'par_page' => QueryValue::int($this->parPage),
        ], static fn (?string $value): bool => null !== $value && '' !== $value);
    }
}
