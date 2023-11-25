<?php
declare(strict_types=1);

namespace App\FileManager\Application\DeleteMedia;

use App\FileManager\Application\FileManipulation\Thumbnails\DeleteThumbnails\DeleteThumbnails;
use App\FileManager\Domain\Event\MediaDeleted;
use App\Shared\Domain\Event\DomainEvent;
use App\Shared\Domain\Event\DomainEventSubscriber;

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
