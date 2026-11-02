<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Query;

/**
 * Filtres de GET /organisation/entreprise/{siren}/etablissement.
 *
 * Immuable : chaque méthode with…() renvoie une copie.
 */
final class EtablissementsQuery
{
    private ?bool $actifs = null;

    /** @var list<string> */
    private array $activites = [];

    /** @var list<string> */
    private array $codesPostaux = [];

    /** @var list<string> */
    private array $numerosDepartements = [];

    private function __construct()
    {
    }

    public static function create(): self
    {
        return new self();
    }

    /**
     * @param bool $actifs true pour les établissements actifs, false pour les fermés
     */
    public function withActifs(bool $actifs): self
    {
        $clone = clone $this;
        $clone->actifs = $actifs;

        return $clone;
    }

    /**
     * @param list<string> $codes codes APE
     */
    public function withActivites(array $codes): self
    {
        $clone = clone $this;
        $clone->activites = $codes;

        return $clone;
    }

    /**
     * @param list<string> $codesPostaux
     */
    public function withCodesPostaux(array $codesPostaux): self
    {
        $clone = clone $this;
        $clone->codesPostaux = $codesPostaux;

        return $clone;
    }

    /**
     * @param list<string> $numeros
     */
    public function withNumerosDepartements(array $numeros): self
    {
        $clone = clone $this;
        $clone->numerosDepartements = $numeros;

        return $clone;
    }

    /**
     * @return array<string, string>
     */
    public function toQuery(): array
    {
        return QueryValue::filter([
            'actifs' => QueryValue::bool($this->actifs),
            'activites' => implode(',', $this->activites),
            // Orthographe imposée par l'API.
            'code_postaux' => implode(',', $this->codesPostaux),
            'numeros_departements' => implode(',', $this->numerosDepartements),
        ]);
    }
}
