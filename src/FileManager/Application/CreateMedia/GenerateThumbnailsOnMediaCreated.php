<?php
declare(strict_types=1);

namespace App\FileManager\Application\CreateMedia;

use App\FileManager\Domain\Contract\MediaRepositoryInterface;
use App\FileManager\Domain\Event\MediaCreated;
use App\FileManager\Domain\Service\GenerateThumbnailsHandler;
use App\FileManager\Domain\ValueObject\MediaId;
use App\Shared\Domain\Event\DomainEventSubscriber;

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
