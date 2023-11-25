<?php

declare(strict_types=1);

namespace App\FileManager\Infrastructure\Event;


use App\FileManager\Application\DataTransformer\Response\MediaResponse;
use Symfony\Contracts\EventDispatcher\Event;

class PostUpdateEvent extends Event
{
    public const NAME = 'ranky.media.post_update';

    protected MediaResponse $mediaResponse;

    public function __construct(MediaResponse $mediaResponse)
    {
        $this->mediaResponse = $mediaResponse;
    }

    public function getMediaResponse(): MediaResponse
    {
        return $this->mediaResponse;
    }
}
