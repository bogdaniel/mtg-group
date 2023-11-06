<?php

namespace App\Service;

use App\Entity\PageMeta;
use App\Repository\PageMetaRepository;
use Doctrine\ORM\EntityManagerInterface;

class PageMetaManager
{
    private $entityManager;
    private $pageMetaRepository;

    public function __construct(EntityManagerInterface $entityManager, PageMetaRepository $pageMetaRepository)
    {
        $this->entityManager = $entityManager;
        $this->pageMetaRepository = $pageMetaRepository;
    }

    public function createPageMeta(PageMeta $pageMeta): void
    {
        $this->entityManager->persist($pageMeta);
        $this->entityManager->flush();
    }

    public function updatePageMeta(PageMeta $pageMeta): void
    {
        $this->entityManager->persist($pageMeta);
        $this->entityManager->flush();
    }

    public function deletePageMeta(PageMeta $pageMeta): void
    {
        $this->entityManager->remove($pageMeta);
        $this->entityManager->flush();
    }
}
