<?php
declare(strict_types=1);

namespace App\Web\MVC\Controller\Finances;

use App\Web\MVC\Controller\AbstractController;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class InvoiceGeneratorController extends AbstractController
{
    public function __construct(private Client $client){}

    public function generateInvoice(Request $request): Response
    {
        $price = $request->get('price');

        $this->client->post(
            'https://api.apify.com/v2/actor-tasks/hc8Wo1kIaahP86ofu/runs?token=PNPFdbmnACY8dYWBmuPGhjaC6',
            [
                'json' => [
                    'url' => "https://mardeus.dev/invoice?price={$price}&token=" . InvoiceController::API_TOKEN,
                    'sleepMillis' => 2000,
                    'pdfOptions' => [
                        'format' => 'a4'
                    ],
                ],
            ]
        );

        return $this->redirectToRoute('dashboard');
    }
}
