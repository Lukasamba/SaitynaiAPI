<?php

namespace Tests;

use Faker\Factory;
use Faker\Generator;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Testing\TestResponse;
use Tests\Helpers\AuthUtilities;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseTransactions, AuthUtilities;

    protected Generator $faker;

    protected string $generic_password = 'password';

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        $this->faker = Factory::create();
        parent::__construct($name, $data, $dataName);
    }

    public function get($uri, array $data = [], array $headers = []): TestResponse
    {
        return parent::get($this->extend_url_with_query_data($uri, $data), array_merge($this->authHeader, $headers));
    }

    public function post($uri, array $data = [], array $headers = []): TestResponse
    {
        return parent::post($uri, $data, array_merge($this->authHeader, $headers));
    }

    public function put($uri, array $data = [], array $headers = []): TestResponse
    {
        return parent::put($uri, $data, array_merge($this->authHeader, $headers));
    }

    public function delete($uri, array $data = [], array $headers = []): TestResponse
    {
        return parent::delete($uri, $data, array_merge($this->authHeader, $headers));
    }

    public function measureTime(callable $fn): float
    {
        $start = microtime(true);
        $fn();
        return microtime(true) - $start;
    }

    private function extend_url_with_query_data(string $url, array $queryData): string
    {
        if (empty($queryData)) {
            return $url;
        }

        $glue = mb_strpos($url, '?') === false ? '?' : '&';

        $queryString = http_build_query($queryData);

        return "{$url}{$glue}{$queryString}";
    }
}
