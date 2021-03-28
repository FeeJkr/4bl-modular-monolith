<?php
declare(strict_types=1);

namespace App\Web\MVC\Controller\Finances;

use App\Web\MVC\Controller\AbstractController;
use DateTime;
use GuzzleHttp\Client;
use PHPHtmlParser\Dom;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class InvoiceController extends AbstractController
{
    private const API_TOKEN = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoiTWFyZGV1cyBTZXJnaWkgU2lyeWkiLCJ0eXBlIjoiaW52b2ljZV9nZW5lcmF0b3JfYXBwbGljYXRpb24iLCJ0b2tlblR5cGUiOiJjcmVhdGVfZm9yX2FwaWZ5In0._YSdCntfCssqYtRsD3L8vnnuBfpnvlWR_6l23yknBn4';

    public function __construct(private Client $client){}

    public function renderInvoice(Request $request): Response
    {
        $token = $request->get('token');

        if ($token === null || $token !== self::API_TOKEN) {
            return new Response('Page not found', 404);
        }

        $netPrice = $request->get('price');
        $vatPrice = ($netPrice / 100) * 23;
        $bruttoPrice = $netPrice + $vatPrice;

        $additionNetPrice = 482;
        $additionVatPrice = ($additionNetPrice / 100) * 23;
        $additionBruttoPrice = $additionNetPrice + $additionVatPrice;

        $dom = new Dom();
        $dom->loadFromUrl(
            sprintf('https://slownie.pl/%s', number_format($bruttoPrice + $additionBruttoPrice, 2, ',', ''))
        );
        /** @var Dom\Node\HtmlNode $p */
        $p = $dom->find('#dataWord')[0];

        $now = new DateTime;
        $previsionMonth = (new DateTime)->setTimestamp(strtotime("-1 months"));

        return $this->render('invoice.html.twig', [
            'nettoPrice' => $request->get('price'),
            'vatPrice' => $vatPrice,
            'bruttoPrice' => $bruttoPrice,
            'totalNetto' => $netPrice + $additionNetPrice,
            'totalVat' => $vatPrice + $additionVatPrice,
            'totalBrutto' => $bruttoPrice + $additionBruttoPrice,
            'textPrice' => $p->innerText ?? '',
            'month' => (new DateTime)->format('m'),
            'generateDay' => $previsionMonth->format('t-m-Y'),
            'paymentDay' => $now->format('10-m-Y'),
            'paymentMonth' => $previsionMonth->format('m'),
        ]);
    }

    public function webhook(Request $request): Response
    {
        $resource = $request->get('resource');
        $id = $resource['id'];
        $actId = $resource['actId'];

        $keyValueStoreId = json_decode(
            $this->client->get("https://api.apify.com/v2/acts/{$actId}/runs/{$id}")->getBody()->getContents(),
            true,
            512,
            JSON_THROW_ON_ERROR
        )['data']['defaultKeyValueStoreId'];

        $file = fopen((new DateTime)->format('Y-m-d H:i:s') . '.pdf', 'w+');

        $this->client->get("https://api.apify.com/v2/key-value-stores/{$keyValueStoreId}/records/OUTPUT", [
            'sink' => $file
        ]);

        return new Response('success');
    }
}