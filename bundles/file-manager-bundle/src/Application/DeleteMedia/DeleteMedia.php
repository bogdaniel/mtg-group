<?php
declare(strict_types=1);

namespace Zenchron\FileBundle\Application\DeleteMedia;

use Zenchron\FileBundle\Domain\Contract\FileRepository;
use Zenchron\FileBundle\Domain\Contract\MediaRepository;
use Zenchron\FileBundle\Domain\ValueObject\MediaId;
use Zenchron\SharedBundle\Domain\Event\DomainEventPublisher;

class DeleteMedia
{

    public function __construct(
        private readonly MediaRepository $mediaRepository,
        private readonly FileRepository $fileRepository,
        private readonly DomainEventPublisher $domainEventPublisher
    ) {
    }


    public function __invoke(string $id): void
    {
        $media    = $this->mediaRepository->getById(MediaId::fromString($id));
        $fileName = $media->file()->name();
        /* Delete from DB */
        $this->mediaRepository->delete($media);
        /* Delete from filesystem */
        $this->fileRepository->delete($fileName);
        /* raised events */
        $this->domainEventPublisher->publish(...$media->recordedEvents());
    }


}
