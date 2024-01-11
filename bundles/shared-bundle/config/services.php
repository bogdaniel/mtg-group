<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;


use Zenchron\SharedBundle\Domain\Event\DomainEventPublisher;
use Zenchron\SharedBundle\Domain\Event\InMemoryDomainEventPublisher;
use Zenchron\SharedBundle\Domain\Site\SiteUrlResolver;
use Zenchron\SharedBundle\Filter\Attributes\CriteriaValueResolver;
use Zenchron\SharedBundle\Filter\Pagination\OffsetPagination;
use Zenchron\SharedBundle\Infrastructure\Persistence\Orm\UidMapperPlatform;
use Zenchron\SharedBundle\Infrastructure\Site\SymfonySiteUrlResolver;

return static function (ContainerConfigurator $configurator) {
    $services = $configurator->services()
        ->defaults()
        ->autoconfigure() // Automatically registers your services as commands, event subscribers, etc
        ->autowire(); // Automatically injects dependencies in your services

    $services
        ->load('Zenchron\\SharedBundle\\', '../src/*')
        ->exclude([
//            '../src/{DependencyInjection,DQL,Contract,Common,Helper,Entity,Trait,Traits,Migrations,Tests,ZenchronSharedBundle.php}',
            '../src/{DependencyInjection,DQL,Contract,Common,Helper,Entity,Trait,Traits,Migrations,Tests}',
            '../src/Infrastructure/DependencyInjection',
            '../src/Presentation/Exception/ApiProblemLogErrorListener.php',
            '../src/**/*Interface.php',
            '../src/Domain',
            '../src/Application/Dto',
            '../src/Exception/',
            '../src/Common',
            '../src/Filter/Order/OrderBy.php',
        ]);

    $services->set(InMemoryDomainEventPublisher::class);
    $services->alias(DomainEventPublisher::class, InMemoryDomainEventPublisher::class);

    // Behat
    $services
        ->load('Zenchron\\SharedBundle\\Presentation\\Behat\\', '../src/Presentation/Behat/*')
        ->exclude([
            '../src/Presentation/Behat/ApiContextTrait.php'
        ]);

    $services->set(SymfonySiteUrlResolver::class);
    $services->alias(SiteUrlResolver::class, SymfonySiteUrlResolver::class);

    /* Criteria: Override service for new $paginationLimit */
    $services->set(CriteriaValueResolver::class)->args([
        '$paginationLimit' => OffsetPagination::DEFAULT_PAGINATION_LIMIT,
    ]);
};
