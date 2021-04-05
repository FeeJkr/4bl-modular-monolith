<?php
declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\Domain\Filesystem;

use App\Modules\Finances\Domain\Filesystem\Apify;
use GuzzleHttp\Client;
use Throwable;

class ApifyApiIntegration implements Apify
{
    private const APIFY_RUN_INFORMATION_URL = 'https://api.apify.com/v2/acts/%s/runs/%s';
    private const APIFY_KEY_VALUE_STORE_OUTPUT_URL = 'https://api.apify.com/v2/key-value-stores/%s/records/OUTPUT';

    public function __construct(private Client $httpClient){}

    public function loadFile(string $resourceId, string $actionId, string $targetPath): void
    {
        try {
            $data = $this->httpClient
                ->get(sprintf(self::APIFY_RUN_INFORMATION_URL, $actionId, $resourceId))
                ->getBody()
                ->getContents();
            $keyValueStoreId = json_decode($data, true, 512, JSON_THROW_ON_ERROR)['data']['defaultKeyValueStoreId'];

            $file = fopen($targetPath, 'wb+');

            $this->httpClient->get(sprintf(self::APIFY_KEY_VALUE_STORE_OUTPUT_URL, $keyValueStoreId), [
                'sink' => $file
            ]);
        } catch (Throwable $exception) {
            throw new \Exception($exception->getMessage());
        }
    }
}