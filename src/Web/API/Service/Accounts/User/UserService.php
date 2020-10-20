<?php
declare(strict_types=1);

namespace App\Web\API\Service\Accounts\User;

use App\Web\API\Request\Accounts\User\RegisterRequest;
use App\Web\API\Request\Accounts\User\SignInRequest;

interface UserService
{
    public function signIn(SignInRequest $request): string;

    /**
     * @param RegisterRequest $request
     * @throws UserRegistrationErrorException
     */
    public function register(RegisterRequest $request): void;
}
