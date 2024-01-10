<?php

declare(strict_types=1);

namespace Zenchron\FileBundle\Infrastructure\Event;


use Zenchron\FileBundle\Application\UpdateMedia\UpdateMediaRequest;
use Symfony\Contracts\EventDispatcher\Event;

class PreUpdateEvent extends Event
{
    public const NAME = 'ranky.media.pre_update';

    protected UpdateMediaRequest $updateMediaRequest;

    public function __construct(UpdateMediaRequest $updateMediaRequest)
    {
        $this->updateMediaRequest = $updateMediaRequest;
    }

    public function getUpdateMediaRequest(): UpdateMediaRequest
    {
        return $this->updateMediaRequest;
    }
}
