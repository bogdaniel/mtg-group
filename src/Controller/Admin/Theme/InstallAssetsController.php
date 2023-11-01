<?php
declare(strict_types=1);

namespace App\Controller\Admin\Theme;

use App\Domain\Entity\ThemeData;
use App\Service\AssetManager;
use App\Service\ThemeManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InstallAssetsController extends AbstractController
{
    private ThemeManager $themeManager;
    private AssetManager $assetManager;

    public function __construct(ThemeManager $themeManager, AssetManager $assetManager)
    {
        $this->themeManager = $themeManager;
        $this->assetManager = $assetManager;
    }

    #[Route("/theme/install/{themeId}", name: "theme_install")]
    public function __invoke(int $themeId): Response
    {
        $theme = $this->themeManager->findThemeById($themeId);
        $themeData = ThemeData::createFromEntity($theme);
        if ($theme) {
            // logic to install theme assets...
            $this->assetManager->copyThemeAssetsToProjectRoot($themeData);
        }

        return $this->redirectToRoute('themes');
    }
}
