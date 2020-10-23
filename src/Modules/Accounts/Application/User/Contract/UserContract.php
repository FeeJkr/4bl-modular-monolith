<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Application\User\Contract;

use App\Modules\Accounts\Application\User\GetToken\GetTokenQuery;
use App\Modules\Accounts\Application\User\GetToken\TokenDTO;
use App\Modules\Accounts\Application\User\Register\RegisterUserCommand;
use App\Modules\Accounts\Application\User\SignIn\SignInUserCommand;
use App\Modules\Accounts\Application\User\SignOut\SignOutUserCommand;

interface UserContract
{
    public function getToken(GetTokenQuery $query): TokenDTO;
    public function register(RegisterUserCommand $command): void;
    public function signIn(SignInUserCommand $command): void;
    public function signOut(SignOutUserCommand $command): void;
}
