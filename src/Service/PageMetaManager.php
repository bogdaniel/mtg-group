<?php

namespace App\Service;

use App\Entity\PageMeta;
use App\Repository\PageMetaRepository;
use App\Repository\PageMetaRepository;

class PageMetaManager
{
    private $pageMetaRepository;

    public function __construct(PageMetaRepository $pageMetaRepository)
    {
        $this->pageMetaRepository = $pageMetaRepository;
    }

    public function createPageMeta(PageMeta $pageMeta): void
    {
        $this->pageMetaRepository->save($pageMeta);
    }

    public function updatePageMeta(PageMeta $pageMeta): void
    {
        $this->pageMetaRepository->save($pageMeta);
    }

    public function deletePageMeta(PageMeta $pageMeta): void
    {
        $this->pageMetaRepository->delete($pageMeta);
    }
}
