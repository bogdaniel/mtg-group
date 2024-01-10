<?php

declare(strict_types=1);

namespace Zenchron\FileBundle\Infrastructure\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Zenchron\SharedBundle\Filter\Attributes\CriteriaValueResolver;

class FileCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $twigGlobal = $container->getDefinition('twig');
        $twigGlobal->addMethodCall(
            'addGlobal',
            [
                'zenchron_file_api_prefix',
                $container->getParameter('zenchron_file_api_prefix') ?? '',
            ],
        );
        $flysystemConfig = $this->getFlysystemConfig($container);
        $mediaConfig = $container->getParameter(FileBundleExtension::CONFIG_DOMAIN_NAME);
        $uploadDirectory = $mediaConfig['upload_directory'];
        if ($flysystemConfig['adapter'] === 'local' && isset($flysystemConfig['options']['directory'])) {
            $uploadDirectory = $flysystemConfig['options']['directory'];
            $mediaConfig['upload_directory'] = $uploadDirectory;
            $container->setParameter(FileBundleExtension::CONFIG_DOMAIN_NAME, $mediaConfig);
        }

        if ($flysystemConfig['adapter'] !== 'local' && !\str_contains($mediaConfig['upload_url'], 'http')) {
            throw new \RuntimeException(
                \sprintf(
                    'Invalid upload url "%s" for adapter "%s". The url must be absolute and start with "http"',
                    $mediaConfig['upload_url'],
                    $flysystemConfig['adapter'],
                ),
            );
        }

        $container->setParameter('zenchron_file_upload_directory', $uploadDirectory);
        $container->setParameter('zenchron_file_adapter', $flysystemConfig['adapter']);

        /**
         * TODO: Criteria Value Resolver
         * Problem: $paginationLimit
         * Alternatives:
         *  * Maintain as is, but in the other cases of use the CriteriaValueResolver,
         *    I will have to explicitly use the paginationLimit in the PHP Criteria Attribute
         * @see \Zenchron\FileBundle\Presentation\Api\ListMediaCriteriaApiController::__invoke()
         *  * Pass limit only by url query string from frontend or PHP Attribute
         *  * Duplicate CriteriaValueResolver by MediaCriteriaValueResolver
         *  * https://symfony.com/doc/current/service_container.html#explicitly-configuring-services-and-arguments
         *  * ...
         */
        $criteriaValueResolverDefinition = $container->getDefinition(CriteriaValueResolver::class);

        /** @var array<string, mixed> $mediaConfig */
        $criteriaValueResolverDefinition->setArgument('$paginationLimit', $mediaConfig['pagination_limit']);
    }


    private function getFlysystemConfig(ContainerBuilder $container): array
    {
        $config = \array_reverse($container->getExtensionConfig('flysystem'));
        $name = FileBundleExtension::CONFIG_FILESYSTEM_STORAGE_NAME;
        foreach ($config as $configItem) {
            if (isset($configItem['storages'][$name])) {
                return $configItem['storages'][$name];
            }
        }
        throw new \RuntimeException(\sprintf('Flysystem storage "%s" not found', $name));
    }
}