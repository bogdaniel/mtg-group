<?php

declare(strict_types=1);

namespace Zenchron\FileManagerBundle\Infrastructure\Event;


use Zenchron\FileManagerBundle\Application\DataTransformer\Response\MediaResponse;
use Symfony\Contracts\EventDispatcher\Event;

class PostCreateEvent extends Event
{
    public const NAME = 'zenchron.media.post_create';

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
