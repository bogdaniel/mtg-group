<?php
declare(strict_types=1);

namespace Zenchron\FileBundle\Application\ListFilter\ListUserFilter;


use Zenchron\FileBundle\Domain\Contract\UserMediaRepository;

class ListUserFilter
{

    public function __construct(private readonly UserMediaRepository $userMediaRepository)
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
