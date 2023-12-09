<?php

declare(strict_types=1);

namespace Zenchron\FileManagerBundle\Infrastructure\Event;


use Zenchron\FileManagerBundle\Domain\ValueObject\MediaId;
use Symfony\Contracts\EventDispatcher\Event;

class DeleteEvent extends Event
{
    public const PRE_DELETE = 'zenchron.media.pre_delete';
    public const POST_DELETE = 'zenchron.media.post_delete';

    protected MediaId $mediaId;

    public function __construct(MediaId $mediaId)
    {
        $this->mediaId = $mediaId;
    }

    public function getMediaId(): MediaId
    {
        return $this->mediaId;
    }
}
