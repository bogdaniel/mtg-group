<?php
declare(strict_types=1);

namespace Zenchron\FileBundle\Application\DeleteMedia;

use Zenchron\FileBundle\Application\FileManipulation\DeleteFile\DeleteThumbnails;
use Zenchron\FileBundle\Domain\Event\MediaDeleted;
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

    public function __invoke(MediaDeleted $mediaDeleted): void
    {
        $this->deleteThumbnails->delete($mediaDeleted->thumbnails());
    }

    public static function priority(): int
    {
        return 0;
    }
}
