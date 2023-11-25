<?php
declare(strict_types=1);

namespace App\FileManager\Domain\Event;

use App\Shared\Domain\Event\AbstractDomainEvent;

/**
 * @property array{ name: string, thumbnails: array } $payload
 * @method array{ name: string, thumbnails: array } payload()
 */
final class MediaDeleted extends AbstractDomainEvent
{
}
