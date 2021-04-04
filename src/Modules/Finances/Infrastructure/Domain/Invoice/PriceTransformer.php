<?php
declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\Domain\Invoice;

use App\Modules\Finances\Domain\Invoice\PriceTransformer as PriceTransformerInterface;
use GuzzleHttp\Client;
use PHPHtmlParser\Dom;
use PHPHtmlParser\Dom\Node\HtmlNode;
use Throwable;

final class PriceTransformer implements PriceTransformerInterface
{
    private const API_URL = 'https://slownie.pl/%s';
    private const API_DATA_SELECTOR = '#dataWord';

    public function __construct(private Client $httpClient){}

    public function transformToText(float $price): string
    {
        try {
            $url = sprintf(self::API_URL, number_format($price, 2, ',', ''));

            return (new Dom)
                ->loadFromUrl($url)
                ->find(self::API_DATA_SELECTOR)[0]
                ->innerText;
        } catch (Throwable) {
            return '';
        }
    }
}