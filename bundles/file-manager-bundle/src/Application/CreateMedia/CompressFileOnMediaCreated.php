<?php
declare(strict_types=1);

namespace Zenchron\FileBundle\Application\CreateMedia;

use Zenchron\FileBundle\Application\FileManipulation\CompressFile\CompressFile;
use Zenchron\FileBundle\Domain\Event\MediaCreated;
use Zenchron\SharedBundle\Domain\Event\DomainEventSubscriber;

class CompressFileOnMediaCreated implements DomainEventSubscriber
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
        return 1;
    }
}
