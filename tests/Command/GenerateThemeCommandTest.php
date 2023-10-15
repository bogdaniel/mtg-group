<?php

namespace App\Tests\Command;

use App\Event\ThemeGeneratedEvent;
use App\Service\ThemeDiscoveryService;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\ApplicationTester;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class GenerateThemeCommandTest extends KernelTestCase
{
    private ApplicationTester $applicationTester;
    private EventDispatcherInterface $eventDispatcher;
    private ThemeDiscoveryService $themeDiscoveryService;
    private Application $application;
    private Command $command;

    public function testExecute(): void
    {
        $this->applicationTester->setInputs([
            'Nexus Theme', // Theme title
            'zenchron/nexus-theme', // Package name
            'A theme for testing', // Description
            'MIT', // License
            'https://example.com', // Homepage
            '1.0.0', // Version
            'Bogdan Olteanu', // Author name
            'bogdan@zenchron.com', // Author email
            'Luminita Smoleanu', // Author name
            'luminita@zenchron.com', // Author email
            '', // Empty author name to stop adding authors
        ]);

        $this->applicationTester->run(['command' => $this->command->getName()]);

        $output = $this->applicationTester->getDisplay();

        $event = new ThemeGeneratedEvent('zenchron/nexus-theme');

        $this->eventDispatcher->dispatch($event);

        $this->assertStringContainsString('Theme zenchron/nexus-theme generated successfully.', $output);
    }

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->application = new Application($kernel);
        $this->application->setAutoExit(false);

        $this->command = $this->application->find('app:generate-theme');
        $this->applicationTester = new ApplicationTester($this->application);

        $this->eventDispatcher = new EventDispatcher();
        $this->themeDiscoveryService = $kernel->getContainer()->get(ThemeDiscoveryService::class);

        $this->eventDispatcher->addSubscriber($kernel->getContainer()->get(\App\EventSubscriber\CommandSubscriber::class));
    }
}
