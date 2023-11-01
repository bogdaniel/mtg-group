<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

#[Route('/dashboard', name: 'app_dashboard', methods: ['GET'])]
class DashboardController extends AbstractController
{
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function __invoke(): Response
    {
        $routes = $this->router->getRouteCollection()->all();

        // Filter and group the routes as needed
        // ...

        dd($routes);
        return $this->render('templates/admin/dashboard.html.twig', [
            'routes' => $routes,
        ]);
    }
}
