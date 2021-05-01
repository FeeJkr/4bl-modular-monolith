<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Filesystem\MoveFileToDropbox;

use App\Common\Application\Command\Command;

class MoveFileToDropboxCommand implements Command
{
    public function __construct(
        private string $sourceFilepath,
        private string $targetFilepath,
    ){}

    public function getSourceFilepath(): string
    {
        return $this->sourceFilepath;
    }

    public function getTargetFilepath(): string
    {
        return $this->targetFilepath;
    }
}