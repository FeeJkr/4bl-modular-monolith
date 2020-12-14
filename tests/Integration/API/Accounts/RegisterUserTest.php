<?php
declare(strict_types=1);

namespace App\Tests\Integration\API\Accounts;

use App\Tests\Integration\API\Accounts\Mother\AccountsMother;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpFoundation\Response;

final class RegisterUserTest extends AccountsBaseTestCase
{
    protected const REGISTER_URI = self::URI . '/register';
    private KernelBrowser $httpClient;

    public function setUp(): void
    {
        parent::setUp();

        $this->httpClient = self::createClient();
    }

    public function tearDown(): void
    {
        $this->httpClient->getContainer()->get('doctrine')->getConnection()->executeQuery('
            DELETE FROM users WHERE email = :email OR email = :secondEmail
        ', [
            'email' => UserItemGenerator::EMAIL,
            'secondEmail' => UserItemGenerator::SECOND_EMAIL,
        ]);

        parent::tearDown();
    }

    /**
     * @test
     */
    public function shouldRegisterUser(): void
    {
        $request = new UserRequestBuilder();

        $this->httpClient->request('POST', self::REGISTER_URI, $request->buildRegister());

        self::assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);
    }

    /**
     * @test
     */
    public function shouldThrowErrorWithEmailDuplication(): void
    {
        $accountsMother = new AccountsMother($this->getHttpClient());
        $accountsMother->registerUser(
            UserItemGenerator::SECOND_USERNAME,
            UserItemGenerator::SECOND_EMAIL,
            UserItemGenerator::SECOND_PASSWORD
        );

        $request = new UserRequestBuilder(
            UserItemGenerator::SECOND_USERNAME,
            UserItemGenerator::SECOND_EMAIL,
            UserItemGenerator::SECOND_PASSWORD
        );

        $this->httpClient->request('POST', self::REGISTER_URI, $request->buildRegister());

        self::assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
    }

    /**
     * @test
     */
    public function shouldSendBadRequest(): void
    {
        $request = new UserRequestBuilder('', '', '');

        $this->httpClient->request('POST', self::REGISTER_URI, $request->buildRegister());

        self::assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
    }

    public function shouldErrorWithLongUsername(): void
    {
        $request = new UserRequestBuilder();
    }
}
