<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Model;

use EntreprisePage\ApiClient\Hydration\Data;

/**
 * Généré par bin/generate-models.php depuis api/docs/swagger.json, ne pas modifier à la main.
 */
final class FormeJuridique
{
    /**
     * Exemple : "EURL"
     *
     * @readonly
     */
    public ?string $abreviation;

    /**
     * Exemple : 5499
     *
     * @readonly
     */
    public int $code;

    /**
     * Exemple : "entreprise unipersonnelle à responsabilité limitée"
     *
     * @readonly
     */
    public string $libelle;

    public function __construct(
        ?string $abreviation,
        int $code,
        string $libelle
    ) {
        $this->abreviation = $abreviation;
        $this->code = $code;
        $this->libelle = $libelle;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Data::nullableString($data, 'abreviation'),
            Data::int($data, 'code'),
            Data::string($data, 'libelle'),
        );
    }
}
