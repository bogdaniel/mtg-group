<?php
declare(strict_types=1);

namespace App\FileManager\Application\DeleteMedia;

use App\FileManager\Domain\Contract\FileRepositoryInterface;
use App\FileManager\Domain\Contract\MediaRepositoryInterface;
use App\FileManager\Domain\ValueObject\MediaId;
use App\Shared\Domain\Event\DomainEventPublisherContract;

class DeleteMedia
{

    public function __construct(
        private readonly MediaRepositoryInterface $mediaRepository,
        private readonly FileRepositoryInterface $fileRepository,
        private readonly DomainEventPublisher $domainEventPublisher
    ) {
    }


    public function __invoke(string $id): void
    {
        $media    = $this->mediaRepository->getById(MediaId::fromString($id));
        $fileName = $media->file()->name();
        /* record events */
        $media->delete();
        /* Delete from DB */
        $this->mediaRepository->delete($media);
        /* Delete from filesystem */
        $this->fileRepository->delete($fileName);
        /* raised events */
        $this->domainEventPublisher->publish(...$media->recordedEvents());
    }


}
