<?php

declare(strict_types=1);

namespace Zenchron\FileManagerBundle\Infrastructure\Event;


use Zenchron\FileManagerBundle\Application\CreateMedia\UploadedFileRequest;
use Symfony\Contracts\EventDispatcher\Event;

class PreCreateEvent extends Event
{
    public const NAME = 'zenchron.media.pre_create';

    protected UploadedFileRequest $uploadedFileRequest;

    public function __construct(UploadedFileRequest $uploadedFileRequest)
    {
        $this->uploadedFileRequest = $uploadedFileRequest;
    }

    public function getUploadedFileRequest(): UploadedFileRequest
    {
        return $this->uploadedFileRequest;
    }
}
