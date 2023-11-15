<?php

namespace App;

use App\Doctrine\AbstractEnumType;
use App\Infrastructure\DependencyInjection\MediaBundleExtension;
use App\Infrastructure\DependencyInjection\MediaCompilerPass;
use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel implements CompilerPassInterface
{
    use MicroKernelTrait;

    private MediaBundleExtension $extension;

    #[NoReturn]
    public function process(ContainerBuilder $container): void
    {
        $typesDefinition = [];
        if ($container->hasParameter('doctrine.dbal.connection_factory.types')) {
            $typesDefinition = $container->getParameter('doctrine.dbal.connection_factory.types');
        }

        $taggedEnums = $container->findTaggedServiceIds('app.doctrine_enum_type');

        /** @var $enumType AbstractEnumType */
        foreach ($taggedEnums as $enumType => $definition) {
            $typesDefinition[$enumType::NAME] = ['class' => $enumType];
        }
        $container->setParameter('doctrine.dbal.connection_factory.types', $typesDefinition);
    }
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);
        $container->addCompilerPass(new MediaCompilerPass()); // PassConfig::TYPE_REMOVE
        if (\class_exists(DoctrineOrmMappingsPass::class))
        {
            $container->addCompilerPass(
                DoctrineOrmMappingsPass::createAttributeMappingDriver(
                    ['App\Domain'],
                    [\dirname(__DIR__).'/src/Domain']
                )
            );
        }
    }

    /**
     * @return \Symfony\Component\DependencyInjection\Extension\ExtensionInterface|null
     */
    public function getContainerExtension(): ?ExtensionInterface
    {
        if (null === $this->extension) {
            $this->extension = new MediaBundleExtension();
        }

        return $this->extension;
    }


    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
