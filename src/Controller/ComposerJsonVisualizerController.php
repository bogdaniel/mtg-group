<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\ComposerJsonVisualizer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class ComposerJsonVisualizerController
{
    private ComposerJsonVisualizer $composerJsonVisualizer;
    private Environment $twig;

    public function __construct(ComposerJsonVisualizer $composerJsonVisualizer, Environment $twig)
    {
        $this->composerJsonVisualizer = $composerJsonVisualizer;
        $this->twig = $twig;
    }

    /**
     * @Route("/visualize", name="composer_json_visualize")
     */
    public function visualize(): Response
    {
        $composerJsonData = $this->composerJsonVisualizer->visualize();

        return new Response($this->twig->render('composer_json_visualizer.html.twig', ['composerJsonData' => $composerJsonData]));
    }
}
