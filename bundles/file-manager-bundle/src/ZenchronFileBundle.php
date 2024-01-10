<?php

declare(strict_types=1);

namespace Zenchron\FileBundle;

use Zenchron\FileBundle\Infrastructure\DependencyInjection\FileBundleExtension;
use Zenchron\FileBundle\Infrastructure\DependencyInjection\FileCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;


class ZenchronFileBundle extends Bundle
{

    public function build(ContainerBuilder $container): void
    {
        parent::build($container);
        $container->addCompilerPass(new FileCompilerPass()); // PassConfig::TYPE_REMOVE
    }

    /**
     * @return \Symfony\Component\DependencyInjection\Extension\ExtensionInterface|null
     */
    public function getContainerExtension(): ?ExtensionInterface
    {
        if (null === $this->extension) {
            $this->extension = new FileBundleExtension();
        }

        return $this->extension;
    }

    public function getPath(): string
    {
        return \dirname(__DIR__);
    }


}
