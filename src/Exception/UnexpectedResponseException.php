<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Exception;

/**
 * La réponse reçue ne correspond pas au contrat de l'API (JSON invalide, champ manquant ou mal typé).
 */
final class UnexpectedResponseException extends \UnexpectedValueException implements ExceptionInterface
{
}
