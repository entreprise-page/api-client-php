<?php

declare(strict_types=1);

namespace EntreprisePage\ApiClient\Tests;

use EntreprisePage\ApiClient\Client;
use Nyholm\Psr7\Factory\Psr17Factory;
use PHPUnit\Framework\TestCase;

abstract class ApiTestCase extends TestCase
{
    protected FakeHttpClient $http;
    protected Client $client;

    protected function setUp(): void
    {
        $this->http = new FakeHttpClient();
        $this->client = new Client('cle-de-test', $this->http, new Psr17Factory(), 'https://api.test/v1');
    }

    /**
     * @return array<string, string>
     */
    protected function lastQuery(): array
    {
        parse_str($this->http->lastRequest()->getUri()->getQuery(), $parsed);

        $query = [];
        foreach ($parsed as $key => $value) {
            self::assertIsString($value);
            $query[(string) $key] = $value;
        }

        return $query;
    }
}
