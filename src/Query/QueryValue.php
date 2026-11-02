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

    /**
     * Retire les critères non renseignés.
     *
     * @param array<string, string|null> $values
     *
     * @return array<string, string>
     */
    public static function filter(array $values): array
    {
        return array_filter($values, static fn (?string $value): bool => null !== $value && '' !== $value);
    }

    public static function float(?float $value): ?string
    {
        // var_export ne dépend pas de la locale, contrairement à (string) avant PHP 8.
        return null === $value ? null : var_export($value, true);
    }
}
