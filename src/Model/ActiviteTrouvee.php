<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final class ActiviteTrouvee
{
    /**
     * Exemple : "43.22A"
     *
     * @readonly
     */
    public string $code;

    /**
     * Exemple : "Travaux d'installation d'eau et de gaz en tous locaux"
     *
     * @readonly
     */
    public ?string $libelle;

    /**
     * Exemple : "Construction"
     *
     * @readonly
     */
    public ?string $section;

    /**
     * Exemple : ["plombier","plomberie","dépannage plomberie"]
     *
     * @var list<string>
     * @readonly
     */
    public array $motsCles;

    /**
     * Exemple : 0.87
     *
     * @readonly
     */
    public ?float $pertinence;

    /**
     * @param list<string> $motsCles
     */
    public function __construct(
        string $code,
        ?string $libelle,
        ?string $section,
        array $motsCles,
        ?float $pertinence
    ) {
        $this->code = $code;
        $this->libelle = $libelle;
        $this->section = $section;
        $this->motsCles = $motsCles;
        $this->pertinence = $pertinence;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Data::string($data, 'code'),
            Data::nullableString($data, 'libelle'),
            Data::nullableString($data, 'section'),
            Data::stringList($data, 'mots_cles'),
            Data::nullableFloat($data, 'pertinence'),
        );
    }
}
