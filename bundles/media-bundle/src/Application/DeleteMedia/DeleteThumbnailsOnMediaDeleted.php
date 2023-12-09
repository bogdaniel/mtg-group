<?php
declare(strict_types=1);

namespace Zenchron\FileManagerBundle\Application\DeleteMedia;

use Zenchron\FileManagerBundle\Application\FileManipulation\Thumbnails\DeleteThumbnails\DeleteThumbnails;
use Zenchron\FileManagerBundle\Domain\Event\MediaDeleted;
use Zenchron\SharedBundle\Domain\Event\DomainEvent;
use Zenchron\SharedBundle\Domain\Event\DomainEventSubscriber;

class DeleteThumbnailsOnMediaDeleted implements DomainEventSubscriber
{


    public function __construct(private readonly DeleteThumbnails $deleteThumbnails)
    {
    }

    public static function subscribedTo(): string
    {
        return MediaDeleted::class;
    }

    public function __invoke(DomainEvent $domainEvent): void
    {
        $this->deleteThumbnails->delete($domainEvent->payload()['thumbnails']);
    }

    public static function priority(): int
    {
        return 0;
    }
}
