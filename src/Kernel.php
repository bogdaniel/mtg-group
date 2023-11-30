<?php

namespace App;

use App\Doctrine\AbstractEnumType;
use App\FileManager\Infrastructure\DependencyInjection\MediaBundleExtension;
use App\FileManager\Infrastructure\DependencyInjection\MediaCompilerPass;
use App\Shared\Infrastructure\DependencyInjection\ShareBundleCompilerPass;
use App\Shared\Infrastructure\DependencyInjection\SharedBundleExtension;
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

    private SharedBundleExtension $extension;

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
        $container->addCompilerPass(new ShareBundleCompilerPass());
        $container->addCompilerPass(new MediaCompilerPass()); // PassConfig::TYPE_REMOVE

        if (\class_exists( 'Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass'))
        {
            $container->addCompilerPass(
                DoctrineOrmMappingsPass::createAttributeMappingDriver(
                    ['App\FileManager\Domain'],
                    [\dirname(__DIR__).'/src/FileManager/Domain']
                )
            );
        }
    }

    public function getContainerExtension(): array
    {
        return new MediaBundleExtension();
//        return [
//            new SharedBundleExtension(),
//            new MediaBundleExtension(),
//        ];

    }

    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
