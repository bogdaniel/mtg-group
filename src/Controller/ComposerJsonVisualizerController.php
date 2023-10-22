<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\ComposerJsonVisualizer;
use Symfony\Component\HttpFoundation\JsonResponse;

class ComposerJsonVisualizerController
{
    private ComposerJsonVisualizer $composerJsonVisualizer;

    public function __construct(ComposerJsonVisualizer $composerJsonVisualizer)
    {
        $this->composerJsonVisualizer = $composerJsonVisualizer;
    }

    public function visualize(): JsonResponse
    {
        $composerJsonData = $this->composerJsonVisualizer->visualize();

        return new JsonResponse($composerJsonData);
    }
}
<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\ComposerJsonVisualizer;
use Symfony\Component\HttpFoundation\JsonResponse;

class ComposerJsonVisualizerController
{
    private ComposerJsonVisualizer $composerJsonVisualizer;

    public function __construct(ComposerJsonVisualizer $composerJsonVisualizer)
    {
        $this->composerJsonVisualizer = $composerJsonVisualizer;
    }

    public function visualize(): JsonResponse
    {
        $composerJsonData = $this->composerJsonVisualizer->visualize();

        return new JsonResponse($composerJsonData);
    }
}
