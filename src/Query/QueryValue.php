<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Query;

/**
 * Formate les valeurs de query string comme les attend l'API (strconv côté Go).
 *
 * @internal
 */
final class QueryValue
{
    public static function bool(?bool $value): ?string
    {
        return null === $value ? null : ($value ? 'true' : 'false');
    }

    public static function int(?int $value): ?string
    {
        return null === $value ? null : (string) $value;
    }

    public static function float(?float $value): ?string
    {
        // (string) sur un float est indépendant de la locale depuis PHP 8.
        return null === $value ? null : (string) $value;
    }
}
