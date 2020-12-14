<?php
declare(strict_types=1);

namespace App\Tests\Integration;

use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class BaseTestCase extends WebTestCase
{
    protected function getHttpClient(): Client
    {
        return new Client(['base_uri' => 'http://localhost:8080']);
    }
}
