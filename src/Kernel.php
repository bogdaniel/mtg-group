<?php

namespace App;

use App\Doctrine\AbstractEnumType;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel implements CompilerPassInterface
{
    use MicroKernelTrait;

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
}
