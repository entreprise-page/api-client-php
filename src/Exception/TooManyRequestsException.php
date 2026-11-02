<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Exception;

/**
 * Le quota d'appels est dépassé (429).
 */
final class TooManyRequestsException extends ApiException
{
}
