<?php
declare(strict_types=1);

namespace App\FileManager\Application\ListFilter\ListMimeFilter;

use App\FileManager\Domain\Contract\MimeMediaRepositoryInterface;

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
