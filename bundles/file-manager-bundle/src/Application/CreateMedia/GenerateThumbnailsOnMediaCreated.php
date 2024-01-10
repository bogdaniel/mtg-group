<?php
declare(strict_types=1);

namespace Zenchron\FileBundle\Application\CreateMedia;

use Zenchron\FileBundle\Domain\Contract\MediaRepository;
use Zenchron\FileBundle\Domain\Event\MediaCreated;
use Zenchron\FileBundle\Domain\Service\GenerateThumbnailsHandler;
use Zenchron\FileBundle\Domain\ValueObject\MediaId;
use Zenchron\SharedBundle\Domain\Event\DomainEventSubscriber;

class GenerateThumbnailsOnMediaCreated implements DomainEventSubscriber
{

    public function __construct(
        private readonly GenerateThumbnailsHandler $generateThumbnailsHandler,
        private readonly MediaRepository $mediaRepository
    ) {
    }

    public static function subscribedTo(): string
    {
        return MediaCreated::class;
    }

    public static function priority(): int
    {
        return 2;
    }


    public function __invoke(MediaCreated $mediaCreated): void
    {
        $media = $this->mediaRepository->getById(MediaId::fromString($mediaCreated->aggregateId()));
        $this->generateThumbnailsHandler->generate(
            $mediaCreated->aggregateId(),
            $media->file(),
            $media->dimension()
        );
    }
}
