<?php
declare(strict_types=1);

namespace Zenchron\FileManagerBundle\Application\CreateMedia;

use Zenchron\FileManagerBundle\Application\FileManipulation\CompressFile\CompressFile;
use Zenchron\FileManagerBundle\Domain\Event\MediaCreated;
use Zenchron\SharedBundle\Domain\Event\DomainEventSubscriber;

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
