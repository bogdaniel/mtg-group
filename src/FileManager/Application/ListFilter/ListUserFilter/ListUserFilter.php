<?php
declare(strict_types=1);

namespace App\FileManager\Application\ListFilter\ListUserFilter;


use App\FileManager\Domain\Contract\UserMediaRepositoryInterface;

class ListUserFilter
{

    public function __construct(private readonly UserMediaRepositoryInterface $userMediaRepository)
    {
    }

    /**
     * @return array<ListUserFilterResponse>
     */
    public function __invoke(): array
    {
        return \array_map(
            static fn($mediaData) => ListUserFilterResponse::fromArray((array)$mediaData),
            $this->userMediaRepository->getAll(),
            []
        );
    }
}
