<?php

namespace App\EventSubscriber;

use App\Event\ThemeGeneratedEvent;
use App\Service\ThemeDiscoveryService;
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
            ThemeGeneratedEvent::NAME => 'onThemeGenerated',
        ];
    }

    public function onThemeGenerated(ThemeGeneratedEvent $event): void
    {
        $this->themeDiscoveryService->discoverThemes();
    }
}
