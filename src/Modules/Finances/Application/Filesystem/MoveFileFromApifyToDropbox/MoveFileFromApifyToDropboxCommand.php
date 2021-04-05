<?php
declare(strict_types=1);

namespace App\Modules\Finances\Application\Filesystem\MoveFileFromApifyToDropbox;

class MoveFileFromApifyToDropboxCommand
{
    public function __construct(
        private string $apifyResourceId,
        private string $apifyActionId,
        private ?string $customDropboxTargetPath = null,
    ){}

    public function getApifyResourceId(): string
    {
        return $this->apifyResourceId;
    }

    public function getApifyActionId(): string
    {
        return $this->apifyActionId;
    }

    public function getCustomDropboxTargetPath(): ?string
    {
        return $this->customDropboxTargetPath;
    }
}