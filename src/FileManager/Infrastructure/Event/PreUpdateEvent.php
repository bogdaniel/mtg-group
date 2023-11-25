<?php

declare(strict_types=1);

namespace App\FileManager\Infrastructure\Event;


use App\FileManager\Application\UpdateMedia\UpdateMediaRequest;
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
