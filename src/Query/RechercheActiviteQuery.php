<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Query;

use EntreprisePage\ApiClient\Exception\InvalidArgumentException;

/**
 * Critères de GET /dictionnaire/recherche/activite.
 *
 * Immuable : chaque méthode with…() renvoie une copie.
 */
final class RechercheActiviteQuery
{
    private string $query;
    private ?string $section = null;
    private ?int $page = null;
    private ?int $parPage = null;

    private function __construct(string $query)
    {
        $this->query = $query;
    }

    /**
     * @param string $query terme en langage courant, par exemple « plombier »
     */
    public static function create(string $query): self
    {
        if ('' === trim($query)) {
            throw new InvalidArgumentException('query est obligatoire.');
        }

        return new self($query);
    }

    /**
     * @param string $section section de la nomenclature, par exemple « Construction »
     */
    public function withSection(string $section): self
    {
        $clone = clone $this;
        $clone->section = $section;

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
     * @param int $parPage de 1 à 100
     */
    public function withParPage(int $parPage): self
    {
        if ($parPage < 1 || $parPage > 100) {
            throw new InvalidArgumentException('parPage doit être compris entre 1 et 100.');
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
            'section' => $this->section,
            'page' => QueryValue::int($this->page),
            'par_page' => QueryValue::int($this->parPage),
        ]);
    }
}
