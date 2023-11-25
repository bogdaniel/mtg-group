<?php
declare(strict_types=1);

namespace App\FileManager\Domain\Contract;

use App\FileManager\Application\CreateMedia\UploadedFileRequest;
use App\FileManager\Domain\ValueObject\Dimension;
use App\FileManager\Domain\ValueObject\File;

interface FileRepositoryInterface
{
    public function upload(UploadedFileRequest $uploadedFileRequest): File;

    public function delete(string $fileName): void;

    public function rename(string $oldPathFileName, string $newPathFileName): void;

    public function filesizeFromPath(string $path): int;

    public function dimensionsFromPath(string $path, string $mime = null): Dimension;

    public function makeDirectory(string $path): void;

}
