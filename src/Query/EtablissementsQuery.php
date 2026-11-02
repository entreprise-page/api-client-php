<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Query;

/**
 * Filtres de GET /organisation/entreprise/{siren}/etablissement.
 */
final readonly class EtablissementsQuery
{
    /**
     * @param bool|null    $actifs              true pour les établissements actifs, false pour les fermés
     * @param list<string> $activites           codes APE
     * @param list<string> $codesPostaux
     * @param list<string> $numerosDepartements
     */
    public function __construct(
        public ?bool $actifs = null,
        public array $activites = [],
        public array $codesPostaux = [],
        public array $numerosDepartements = [],
    ) {
    }

    /**
     * @return array<string, string>
     */
    public function toQuery(): array
    {
        return array_filter([
            'actifs' => QueryValue::bool($this->actifs),
            'activites' => implode(',', $this->activites),
            // Orthographe imposée par l'API.
            'code_postaux' => implode(',', $this->codesPostaux),
            'numeros_departements' => implode(',', $this->numerosDepartements),
        ], static fn (?string $value): bool => null !== $value && '' !== $value);
    }
}
