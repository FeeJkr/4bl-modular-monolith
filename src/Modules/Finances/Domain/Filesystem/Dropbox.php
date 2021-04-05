<?php
declare(strict_types=1);

namespace App\Modules\Finances\Domain\Filesystem;

interface Dropbox
{
    public function upload(string $filepath, ?string $customTargetPath = null): void;
}