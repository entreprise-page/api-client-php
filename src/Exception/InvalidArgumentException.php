<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Exception;

/**
 * Les paramètres passés au SDK sont invalides : la requête n'a pas été envoyée.
 */
final class InvalidArgumentException extends \InvalidArgumentException implements ExceptionInterface
{
}
