<?php

namespace App\EventSubscriber;

use App\Service\ThemeDiscoveryService;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\Console\Event\ConsoleTerminateEvent;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CommandSubscriber implements EventSubscriberInterface
{
    private ThemeDiscoveryService $themeDiscoveryService;

    public function __construct(ThemeDiscoveryService $themeDiscoveryService)
    {
        $this->themeDiscoveryService = $themeDiscoveryService;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ConsoleEvents::TERMINATE => 'onCommandTerminate',
            ConsoleCommandEvent::class => 'onConsoleCommandTerminate'
        ];
    }

    public function onCommandTerminate(ConsoleTerminateEvent $event): void
    {
        $commandName = $event->getCommand()->getName();
        if ($commandName === 'app:generate-theme') {
            $this->themeDiscoveryService->discoverThemes();
        }
    }

    public function onConsoleCommandTerminate(ConsoleCommandEvent $event)
    {
        $commandName = $event->getCommand()->getName();
        if ($commandName === 'cache:clear') {
            $this->themeDiscoveryService->discoverThemes();
        }
    }
}
