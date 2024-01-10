<?php
declare(strict_types=1);

namespace Zenchron\FileBundle\Domain\Event;

use Zenchron\SharedBundle\Domain\Event\AbstractDomainEvent;

/**
 * @phpstan-import-type ThumbnailArray from \Ranky\FileBundle\Domain\ValueObject\Thumbnail
 * @property array{ name: string, thumbnails: array<ThumbnailArray> } $payload
 * @method array{ name: string, thumbnails: array<ThumbnailArray> } payload()
 */
final class MediaThumbnailsAdded extends AbstractDomainEvent
{
    public function name(): string
    {
        return $this->payload()['name'];
    }

    /**
     * @return array<ThumbnailArray>
     */
    public function thumbnails(): array
    {
        return $this->payload()['thumbnails'];
    }
}