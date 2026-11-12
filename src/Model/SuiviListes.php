<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final class SuiviListes
{
    /**
     * @var list<SuiviListe>
     * @readonly
     */
    public array $listes;

    /**
     * Exemple : 5
     *
     * @readonly
     */
    public int $maxListe;

    /**
     * @param list<SuiviListe> $listes
     */
    public function __construct(
        array $listes,
        int $maxListe
    ) {
        $this->listes = $listes;
        $this->maxListe = $maxListe;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Data::objectList($data, 'listes', [SuiviListe::class, 'fromArray']),
            Data::int($data, 'max_liste'),
        );
    }
}
