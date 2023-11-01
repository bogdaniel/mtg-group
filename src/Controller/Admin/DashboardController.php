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
        foreach ($routes as $routeName => $route) {
            if (str_starts_with($routeName, '_profiler') || str_starts_with($routeName, '_wdt') || str_starts_with($routeName, '_preview_error')) {
                unset($routes[$routeName]);
            }
        }

        return $this->render('templates/admin/dashboard.html.twig', [
            'routes' => $routes,
        ]);
    }
}
