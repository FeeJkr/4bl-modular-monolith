<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Domain\Filesystem;

use App\Modules\Invoices\Domain\Filesystem\Dropbox;
use Exception;
use GuzzleHttp\Client;

class DropboxApiIntegration implements Dropbox
{
    private const DROPBOX_UPLOAD_URL = 'https://content.dropboxapi.com/2/files/upload';

    public function __construct(private Client $httpClient, private string $dropboxAuthorizationToken){}

    public function upload(string $sourceFilepath, string $targetFilepath): void
    {
        try {
            $this->httpClient->post(self::DROPBOX_UPLOAD_URL, [
                'headers' => [
                    'Authorization' => sprintf('Bearer %s', $this->dropboxAuthorizationToken),
                    'Content-Type' => 'application/octet-stream',
                    'Dropbox-API-Arg' => json_encode(['path' => $targetFilepath], JSON_THROW_ON_ERROR),
                ],
                'body' => fopen($sourceFilepath, 'rb'),
            ]);
        } catch (\Throwable $exception) {
            throw new Exception($exception->getMessage());
        }
    }
}