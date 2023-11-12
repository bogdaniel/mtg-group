<?php

namespace App\Twig;

use Symfony\Component\Asset\Packages;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class PlaceholderImageExtension extends AbstractExtension
{
    private $packages;
    private $defaultImage;

    public function __construct(Packages $packages, string $defaultImage)
    {
        $this->packages = $packages;
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
        $imagePath = $this->packages->getUrl($path);

        if (!file_exists($imagePath)) {
            return $this->packages->getUrl($this->defaultImage);
        }

        return $imagePath;
    }
}
