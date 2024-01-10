<?php

declare(strict_types=1);


namespace Zenchron\FileBundle\Infrastructure\Persistence\Dql;

use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;
use Zenchron\SharedBundle\Common\ClassHelper;

class LoadDqlFunctionsSubscriber implements EventSubscriberInterface
{

    public function getSubscribedEvents(): array
    {
        return [
            Events::loadClassMetadata,
        ];
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs): void
    {
        $config        = $eventArgs->getEntityManager()->getConfiguration();
        $platform      = $eventArgs->getEntityManager()->getConnection()->getDatabasePlatform();
        $classPlatform = ClassHelper::className($platform::class);

        $functions = DqlFunctionsManager::getFunctionsByClassPlatform($classPlatform);

        if (isset($functions['string_functions'])) {
            foreach ($functions['string_functions'] as $name => $function) {
                $config->addCustomStringFunction($name, $function);
            }
        }
        if (isset($functions['datetime_functions'])) {
            foreach ($functions['datetime_functions'] as $name => $function) {
                $config->addCustomDatetimeFunction($name, $function);
            }
        }
        if (isset($functions['numeric_functions'])) {
            foreach ($functions['numeric_functions'] as $name => $function) {
                $config->addCustomNumericFunction($name, $function);
            }
        }
    }
}
