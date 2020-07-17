<?php
declare(strict_types=1);

namespace App\UI\Web\Controller;

use Firebase\JWT\JWT;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class IndexController extends AbstractController
{
    public function generateJWT(): Response
    {
        $key = 'testing_on_dev';
        $payload = [
            'iss' => 'feejkr',
            'exp' => (new \DateTime())->modify('+ 30 days')->getTimestamp(),
            'user_id' => 1234,
        ];

        $jwt = JWT::encode($payload, $key, 'HS256');

        dd($jwt);
    }

    public function index(Request $request): Response
    {
        return new Response('You are authenticated.' . $request->get('user_id'));
    }
}
