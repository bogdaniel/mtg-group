<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\ComposerJsonVisualizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ComposerJsonVisualizerController extends AbstractController
{
    private ComposerJsonVisualizer $composerJsonVisualizer;

    public function __construct(ComposerJsonVisualizer $composerJsonVisualizer)
    {
        $this->composerJsonVisualizer = $composerJsonVisualizer;
    }

    #[Route("/visualize", name: "composer_json_visualize")]
    public function __invoke(): Response
    {
        $composerJsonData = $this->composerJsonVisualizer->visualize();

        return $this->render('composer_json_visualizer.html.twig', [
            'composerJsonData' => $composerJsonData,
            'installedPackages' => $composerJsonData->installedPackages
        ]);
    }
}
