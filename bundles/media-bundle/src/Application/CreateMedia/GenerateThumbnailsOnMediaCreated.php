<?php
declare(strict_types=1);

namespace Zenchron\FileManagerBundle\Application\CreateMedia;

use Zenchron\FileManagerBundle\Domain\Contract\MediaRepositoryInterface;
use Zenchron\FileManagerBundle\Domain\Event\MediaCreated;
use Zenchron\FileManagerBundle\Domain\Service\GenerateThumbnailsHandler;
use Zenchron\FileManagerBundle\Domain\ValueObject\MediaId;
use Zenchron\SharedBundle\Domain\Event\DomainEventSubscriber;

class GenerateThumbnailsOnMediaCreated implements DomainEventSubscriber
{

    public function __construct(
        private readonly GenerateThumbnailsHandler $generateThumbnailsHandler,
        private readonly MediaRepositoryInterface $mediaRepository
    ) {
    }

    public static function subscribedTo(): string
    {
        return MediaCreated::class;
    }

    public static function priority(): int
    {
        return 1;
    }


    public function __invoke(MediaCreated $mediaCreated): void
    {
        $media = $this->mediaRepository->getById(MediaId::fromString($mediaCreated->aggregateId()));
        $this->generateThumbnailsHandler->generate($mediaCreated->aggregateId(), $media->file());
    }
}
