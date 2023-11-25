<?php
declare(strict_types=1);

namespace App\FileManager\Domain\Event;

use App\Shared\Domain\Event\AbstractDomainEvent;

/**
 * @property array{ name: string } $payload
 * @method array{ name: string } payload()
 */
final class MediaFileUpdated extends AbstractDomainEvent
{

}
