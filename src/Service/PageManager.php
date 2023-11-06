<?php

namespace App\Service;

use App\Entity\Page;
use App\Repository\PageRepository;
use Doctrine\ORM\EntityManagerInterface;

class PageManager
{
    private $entityManager;
    private $pageRepository;

    public function __construct(EntityManagerInterface $entityManager, PageRepository $pageRepository)
    {
        $this->entityManager = $entityManager;
        $this->pageRepository = $pageRepository;
    }

    public function createPage(Page $page): void
    {
        $this->entityManager->persist($page);
        $this->entityManager->persist($page->pageMeta);
        $this->entityManager->flush();
    }

    public function updatePage(Page $page): void
    {
        $this->entityManager->persist($page);
        $this->entityManager->persist($page->pageMeta);
        $this->entityManager->flush();
    }

    public function deletePage(Page $page): void
    {
        $this->entityManager->remove($page);
        $this->entityManager->flush();
    }

    public function getAllPages(): array
    {
        return $this->pageRepository->findAll();
    }
}
