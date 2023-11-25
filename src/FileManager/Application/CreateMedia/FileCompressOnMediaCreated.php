<?php
declare(strict_types=1);

namespace App\FileManager\Application\CreateMedia;

use App\FileManager\Application\FileManipulation\CompressFile\CompressFile;
use App\FileManager\Domain\Event\MediaCreated;
use App\Shared\Domain\Event\DomainEventSubscriber;

class FileCompressOnMediaCreated implements DomainEventSubscriber
{

    public function __construct(
        private readonly CompressFile $compressFile
    ) {
    }

    public static function subscribedTo(): string
    {
        return MediaCreated::class;
    }


    public function __invoke(MediaCreated $mediaCreated): void
    {
        $this->compressFile->__invoke($mediaCreated->aggregateId());
    }

    public static function priority(): int
    {
        return 0;
    }
}
