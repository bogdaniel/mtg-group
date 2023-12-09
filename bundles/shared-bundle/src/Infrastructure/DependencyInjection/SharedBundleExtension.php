<?php
declare(strict_types=1);

namespace Zenchron\SharedBundle\Infrastructure\DependencyInjection;

use Zenchron\SharedBundle\Domain\Event\DomainEventSubscriber;
use Zenchron\SharedBundle\Filter\Visitor\Extension\FilterExtensionVisitor;
use Zenchron\SharedBundle\Infrastructure\Persistence\Dbal\Types\UserIdentifierType;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class SharedBundleExtension extends Extension implements PrependExtensionInterface
{
    public const CONFIG_DOMAIN               = 'ranky_shared';
    public const TAG_DOMAIN_EVENT_SUBSCRIBER = 'zenchron.domain_event_subscriber';

    public function getAlias(): string
    {
        return self::CONFIG_DOMAIN;
    }

    /**
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        // Event
        $container->registerForAutoconfiguration(DomainEventSubscriber::class)
            ->addTag(self::TAG_DOMAIN_EVENT_SUBSCRIBER);
        // COLLECT FILTERS
        $container->registerForAutoconfiguration(FilterExtensionVisitor::class)
            ->addTag(FilterExtensionVisitor::TAG_NAME)
        ;
        $phpLoader = new PhpFileLoader($container, new FileLocator(__DIR__.'/../../../config'));
        $phpLoader->load('services.php');


    }

    public function prepend(ContainerBuilder $container): void
    {
        $container->prependExtensionConfig('doctrine', [
            'dbal' => [
                'types' => [
                    'user_identifier' => UserIdentifierType::class,
                ],
            ],
        ]);
    }


}
