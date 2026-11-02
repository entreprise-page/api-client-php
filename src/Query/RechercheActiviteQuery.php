<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Query;

use EntreprisePage\ApiClient\Exception\InvalidArgumentException;

/**
 * Critères de GET /dictionnaire/recherche/activite.
 */
final readonly class RechercheActiviteQuery
{
    /**
     * @param string      $query   terme en langage courant, par exemple « plombier »
     * @param string|null $section restreint à une section de la nomenclature, par exemple « Construction »
     * @param int|null    $parPage 1 à 100
     */
    public function __construct(
        public string $query,
        public ?string $section = null,
        public ?int $page = null,
        public ?int $parPage = null,
    ) {
        if ('' === trim($query)) {
            throw new InvalidArgumentException('query est obligatoire.');
        }
        if (null !== $page && $page < 1) {
            throw new InvalidArgumentException('page doit être supérieure ou égale à 1.');
        }
        if (null !== $parPage && ($parPage < 1 || $parPage > 100)) {
            throw new InvalidArgumentException('parPage doit être compris entre 1 et 100.');
        }
    }

    /**
     * @return array<string, string>
     */
    public function toQuery(): array
    {
        return array_filter([
            'query' => $this->query,
            'section' => $this->section,
            'page' => QueryValue::int($this->page),
            'par_page' => QueryValue::int($this->parPage),
        ], static fn (?string $value): bool => null !== $value && '' !== $value);
    }
}
