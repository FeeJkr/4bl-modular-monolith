<?php
declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\Domain\Invoice;

use App\Modules\Finances\Domain\Invoice\PdfFromHtmlGenerator;
use App\Modules\Finances\Domain\Invoice\Invoice;
use GuzzleHttp\Client;
use Symfony\Component\Messenger\MessageBusInterface;

class ApifyPdfFromHtmlGenerator implements PdfFromHtmlGenerator
{
    private const APIFY_URL = 'https://api.apify.com/v2/actor-tasks/hc8Wo1kIaahP86ofu/runs?token=PNPFdbmnACY8dYWBmuPGhjaC6';

    public function __construct(
        private Client $httpClient,
        private MessageBusInterface $bus,
        private string $host,
        private string $token,
    ){}

    public function generate(Invoice $invoice): void
    {
        $url = sprintf(
            '%s/multimedia/finances/invoice?id=%s&invoiceToken=%s&token=%s',
            rtrim($this->host, '/'),
            $invoice->getId()->toInt(),
            $invoice->getToken(),
            $this->token,
        );

        $this->httpClient->post(
            self::APIFY_URL,
            [
                'json' => [
                    'url' => $url,
                    'sleepMillis' => 2000,
                    'pdfOptions' => [
                        'format' => 'a4',
                    ],
                ],
            ]
        );
    }
}