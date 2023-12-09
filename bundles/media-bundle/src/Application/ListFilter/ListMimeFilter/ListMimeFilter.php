<?php
declare(strict_types=1);

namespace Zenchron\FileManagerBundle\Application\ListFilter\ListMimeFilter;

use Zenchron\FileManagerBundle\Domain\Contract\MimeMediaRepositoryInterface;

class ListMimeFilter
{

    public function __construct(private readonly MimeMediaRepositoryInterface $mimeMediaRepository)
    {
    }

    /**
     * @return array<ListMimeFilterResponse>
     */
    public function __invoke(): array
    {
        return \array_map(
            static fn($mediaData) => ListMimeFilterResponse::fromArray((array)$mediaData),
            $this->mimeMediaRepository->getAllByType(),
            []
        );
    }
}
