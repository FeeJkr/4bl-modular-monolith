<?php
declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Company\Create;

use Assert\InvalidArgumentException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateCompanyValidationErrorResponse
{
	public static function getResponse(Request $request, array $errors): Response
	{
		$allRequestFields = $request->request->all();
		$response = [];

		$response['errors'] = array_map(
			static function (InvalidArgumentException $error) use ($allRequestFields): array {
				unset($allRequestFields[$error->getPropertyPath()]);

				return [
					'message' => $error->getMessage(),
					'value' => $error->getValue(),
					'propertyPath' => $error->getPropertyPath(),
				];
			},
			$errors
		);

		$response['old'] = $allRequestFields;

		return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
	}
}