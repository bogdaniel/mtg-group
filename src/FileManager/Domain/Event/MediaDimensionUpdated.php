<?php
declare(strict_types=1);

namespace App\FileManager\Domain\Event;

use App\Shared\Domain\Event\AbstractDomainEvent;

/**
 * @property array{ dimension: array } $payload
 * @method array{ dimension: array } payload()
 */
final class MediaDimensionUpdated extends AbstractDomainEvent
{

}
