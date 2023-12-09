<?php
declare(strict_types=1);

namespace Zenchron\FileManagerBundle\Domain\Event;

use Zenchron\SharedBundle\Domain\Event\AbstractDomainEvent;

/**
 * @property array{ name: string } $payload
 * @method array{ name: string } payload()
 */
final class MediaCreated extends AbstractDomainEvent
{

}
