<?php

namespace App\EventSubscriber;

use App\Service\ThemeRuntimeConfigurator;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ThemeConfiguratorSubscriber implements EventSubscriberInterface
{
    private ThemeRuntimeConfigurator $themeRuntimeConfigurator;

    public function __construct(ThemeRuntimeConfigurator $themeRuntimeConfigurator)
    {
        $this->themeRuntimeConfigurator = $themeRuntimeConfigurator;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if ($event->isMasterRequest()) {
            $this->themeRuntimeConfigurator->configure();
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }
}
