<?php

namespace App\Service;

use App\Entity\Page;
use App\Enum\PageStatusEnum;
use App\Repository\PageRepository;

class PageManager
{
    private PageRepository $pageRepository;

    public function __construct(PageRepository $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    public function createPage(Page $page): void
    {
        $this->pageRepository->save($page);
    }

    public function updatePage(Page $page): void
    {
        $this->pageRepository->save($page);
    }

    public function deletePage(Page $page): void
    {
        $this->pageRepository->delete($page);
    }

    public function getAllPages(): array
    {
        return $this->pageRepository->findAll();
    }

    public function getPublishedPages(): array
    {
        return $this->pageRepository->findBy(['status' => PageStatusEnum::PUBLISHED]);
    }
}
