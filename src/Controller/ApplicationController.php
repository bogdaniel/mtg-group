<?php

namespace App\Controller;

use App\Service\PageManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApplicationController extends BaseController
{
    private PageManager $pageManager;

    public function __construct(PageManager $pageManager)
    {
        $this->pageManager = $pageManager;
    }

    // use attributes to define routes
    #[Route('/')]
    public function __invoke()
    {
        // let's retrieve all the pages which are published from the database using PageManager service
        $pages = $this->pageManager->getPublishedPages();
dd($pages);
        dump($pages);
        return new Response('Hello World!');
    }
}
