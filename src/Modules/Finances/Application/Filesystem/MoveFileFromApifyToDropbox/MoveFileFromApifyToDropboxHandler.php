<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Filesystem\MoveFileFromApifyToDropbox;

use App\Modules\Finances\Domain\Filesystem\Apify;
use App\Modules\Finances\Domain\Filesystem\Dropbox;
use Ramsey\Uuid\Uuid;

class MoveFileFromApifyToDropboxHandler
{
    public function __construct(
        private Apify $apify,
        private Dropbox $dropbox,
    ){}

    public function __invoke(MoveFileFromApifyToDropboxCommand $command): void
    {
        $filepath = sprintf('%s.pdf', Uuid::uuid4()->toString());

        $this->apify->loadFile($command->getApifyResourceId(), $command->getApifyActionId(), $filepath);
        $this->dropbox->upload($filepath, $command->getCustomDropboxTargetPath());

        unlink($filepath);
    }
}