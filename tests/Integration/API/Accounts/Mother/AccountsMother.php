<?php
declare(strict_types=1);

namespace App\Tests\Integration\API\Accounts\Mother;

use App\Tests\Integration\API\Accounts\UserRequestBuilder;
use GuzzleHttp\ClientInterface;

final class AccountsMother
{
    private const URI = '/api/v1/accounts';

    public function __construct(private ClientInterface $httpClient) {}

    public function registerUser(string $username, string $email, string $password): void
    {
        $requestBuilder = new UserRequestBuilder($username, $email, $password);

        $this->httpClient->request(
            'POST',
            sprintf('%s/register', self::URI),
            ['form_params' => $requestBuilder->buildRegister()]
        );
    }
}
