<?php
declare(strict_types=1);

namespace App\Modules\Accounts\Infrastructure\UI\Http\Api;

use Firebase\JWT\JWT;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class GenerateJWTTokenAction extends AbstractController
{
    private string $jwtSecretKey;

    public function __construct(string $jwtSecretKey)
    {
        $this->jwtSecretKey = $jwtSecretKey;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $payload = [
            'exp' => (new \DateTime())->modify('+ 30 days')->getTimestamp(),
            'user_id' => $request->get('user_id', 1234),
        ];

        $jwt = JWT::encode($payload, $this->jwtSecretKey, 'HS256');

        return $this->json(['token' => $jwt]);
    }
}
