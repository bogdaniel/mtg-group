<?php
declare(strict_types=1);

namespace App\FileManager\Domain\Event;

use App\Shared\Domain\Event\AbstractDomainEvent;

/**
 * @property array{ oldSize: int, newSize: int } $payload
 * @method array{ oldSize: int, newSize: int } payload()
 */
final class MediaFileSizeUpdated extends AbstractDomainEvent
{

}
