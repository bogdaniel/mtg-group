<?php

namespace App\EventSubscriber;

use App\Service\ThemeDiscoveryService;
use Symfony\Component\Console\Event\ConsoleTerminateEvent;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CommandSubscriber implements EventSubscriberInterface
{
    private $themeDiscoveryService;

    public function __construct(ThemeDiscoveryService $themeDiscoveryService)
    {
        $this->themeDiscoveryService = $themeDiscoveryService;
    }

    public static function getSubscribedEvents()
    {
        return [
            ConsoleEvents::TERMINATE => 'onCommandTerminate',
        ];
    }

    public function onCommandTerminate(ConsoleTerminateEvent $event)
    {
        $commandName = $event->getCommand()->getName();

        if ($commandName === 'cache:clear' || $commandName === 'app:generate-theme') {
            $this->themeDiscoveryService->discoverThemes();
        }
    }
}
