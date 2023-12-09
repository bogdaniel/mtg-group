<?php
declare(strict_types=1);

namespace Zenchron\FileManagerBundle\Domain\Event;

use Zenchron\SharedBundle\Domain\Event\AbstractDomainEvent;

/**
 * @property array{ dimension: array } $payload
 * @method array{ dimension: array } payload()
 */
final class MediaDimensionUpdated extends AbstractDomainEvent
{

}
