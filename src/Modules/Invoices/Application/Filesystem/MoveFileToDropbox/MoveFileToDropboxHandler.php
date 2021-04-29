<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Application\Filesystem\MoveFileToDropbox;

use App\Modules\Invoices\Domain\Filesystem\Apify;
use App\Modules\Invoices\Domain\Filesystem\Dropbox;
use Ramsey\Uuid\Uuid;

class MoveFileToDropboxHandler
{
    public function __construct(private Dropbox $dropbox,){}

    public function __invoke(MoveFileToDropboxCommand $command): void
    {
        $this->dropbox->upload($command->getSourceFilepath(), $command->getTargetFilepath());

        unlink($command->getSourceFilepath());
    }
}