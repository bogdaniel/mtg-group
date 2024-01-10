<?php
declare(strict_types=1);

namespace Zenchron\FileBundle\Domain\Event;

use Zenchron\SharedBundle\Domain\Event\AbstractDomainEvent;

/**
 * @property array{ name: string } $payload
 * @method array{ name: string } payload()
 */
final class MediaFileChanged extends AbstractDomainEvent
{
    public function name(): string
    {
        return $this->payload()['name'];
    }

}