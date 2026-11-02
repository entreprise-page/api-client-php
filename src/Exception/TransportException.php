<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Exception;

/**
 * La requête n'a pas pu aboutir (réseau, DNS, timeout…) : aucune réponse HTTP n'a été reçue.
 */
final class TransportException extends \RuntimeException implements ExceptionInterface
{
}
