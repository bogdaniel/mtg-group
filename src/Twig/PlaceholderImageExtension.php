<?php

namespace App\Twig;

use Symfony\Bridge\Twig\Extension\AssetExtension;
use Symfony\Component\Asset\Packages;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class PlaceholderImageExtension extends AssetExtension
{
    private $defaultImage;

    public function __construct(Packages $packages, string $defaultImage)
    {
        parent::__construct($packages);
        $this->defaultImage = $defaultImage;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('asset_image', [$this, 'getAssetImage']),
        ];
    }

    public function getAssetImage(string $path): string
    {
        $imagePath = $this->getAssetUrl($path);

        if (!file_exists($imagePath)) {
            return $this->getAssetUrl($this->defaultImage);
        }

        return $imagePath;
    }
}
