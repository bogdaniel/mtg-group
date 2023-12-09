<?php

declare(strict_types=1);

namespace Zenchron\FileManagerBundle\Infrastructure\Event;


use Zenchron\FileManagerBundle\Application\DataTransformer\Response\MediaResponse;
use Symfony\Contracts\EventDispatcher\Event;

class PostUpdateEvent extends Event
{
    public const NAME = 'zenchron.media.post_update';

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
