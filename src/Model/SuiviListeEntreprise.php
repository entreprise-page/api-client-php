<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final class SuiviListeEntreprise
{
    /**
     * @var list<SuiviEntreprise>
     * @readonly
     */
    public array $entreprises;

    /**
     * Exemple : 1
     *
     * @readonly
     */
    public int $id;

    /**
     * Exemple : "Prospects"
     *
     * @readonly
     */
    public string $nom;

    /**
     * @readonly
     */
    public SuiviPagination $pagination;

    /**
     * @param list<SuiviEntreprise> $entreprises
     */
    public function __construct(
        array $entreprises,
        int $id,
        string $nom,
        SuiviPagination $pagination
    ) {
        $this->entreprises = $entreprises;
        $this->id = $id;
        $this->nom = $nom;
        $this->pagination = $pagination;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Data::objectList($data, 'entreprises', [SuiviEntreprise::class, 'fromArray']),
            Data::int($data, 'id'),
            Data::string($data, 'nom'),
            Data::object($data, 'pagination', [SuiviPagination::class, 'fromArray']),
        );
    }
}
