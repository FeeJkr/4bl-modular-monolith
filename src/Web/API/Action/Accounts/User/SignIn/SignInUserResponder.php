<?php
declare(strict_types=1);

namespace App\Web\API\Action\Accounts\User\SignIn;

use App\Modules\Accounts\Application\User\GetToken\TokenDTO;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class SignInUserResponder
{
    public function respond(Request $request, TokenDTO $tokenDTO): Response
	{
		$request->getSession()->set('user.token', $tokenDTO->getToken());

		return new JsonResponse(
			['token' => $tokenDTO->getToken()]
		);
	}
}
