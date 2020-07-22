<?php
declare(strict_types=1);

namespace App\UI\Web\Controller;

use Firebase\JWT\JWT;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class IndexController extends AbstractController
{
    private $jwtSecretKey;

    public function __construct(string $jwtSecretKey)
    {
        $this->jwtSecretKey = $jwtSecretKey;
    }

    public function generateJWT(Request $request): Response
    {
        $payload = [
            'exp' => (new \DateTime())->modify('+ 30 days')->getTimestamp(),
            'user_id' => $request->get('user_id', 1234),
        ];

        $jwt = JWT::encode($payload, $this->jwtSecretKey, 'HS256');

        return $this->json(['token' => $jwt]);
    }

    public function index(Request $request): Response
    {
        return new Response('You are authenticated.' . $request->get('user_id'));
    }
}
