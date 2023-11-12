<?php

namespace App\Twig;

use Symfony\Component\Asset\Packages;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class PlaceholderImageExtension extends AbstractExtension
{
    private Packages $packages;
    private string $defaultImage;

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

    public function getAssetImage(string $path, string $packageName = null): string
    {
        dump(file_exists($this->packages->getUrl($path, $packageName)));
        $imagePath = $this->packages->getUrl($path, $packageName);
        if (!file_exists($imagePath)) {

            return $this->packages->getUrl($this->defaultImage, $packageName);
        }

        return $imagePath;
    }
}
