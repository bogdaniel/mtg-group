<?php

namespace App\Service;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class FileManagerExtensionService
{
    public function loadConfiguration(ContainerBuilder $container)
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../../config/packages')
        );
        $loader->load('file_manager.yaml');
    }
}
