<?php

namespace App\Tests\Command;

use App\Service\ThemeDiscoveryService;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\Console\Event\ConsoleTerminateEvent;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class GenerateThemeCommandTest extends KernelTestCase
{
    private CommandTester $commandTester;
    private EventDispatcherInterface $eventDispatcher;
    private ThemeDiscoveryService $themeDiscoveryService;

    public function testExecute(): void
    {
        $this->commandTester->setInputs([
            'Nexus Theme', // Theme title
            'zenchron/nexus-theme', // Package name
            'A theme for testing', // Description
            'MIT', // License
            'https://example.com', // Homepage
            'Bogdan Olteanu', // Author name
            'bogdan@zenchron.com', // Author email
            'Luminita Smoleanu', // Author name
            'luminita@zenchron.com', // Author email
            '', // Empty author name to stop adding authors
            '1.0.0', // Version
        ]);

        $command = $this->commandTester->getCommand();
        $this->commandTester->execute([]);

        $output = $this->commandTester->getDisplay();
        $exitCode = $this->commandTester->getStatusCode();

        $this->eventDispatcher->dispatch(new ConsoleTerminateEvent($command, $this->commandTester->getInput(), $exitCode));

        $this->assertStringContainsString('Theme zenchron/nexus-theme generated successfully.', $output);
    }

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find('app:generate-theme');
        $this->commandTester = new CommandTester($command);

        $this->eventDispatcher = new EventDispatcher();
        $this->themeDiscoveryService = $kernel->getContainer()->get(ThemeDiscoveryService::class);

        $this->eventDispatcher->addSubscriber($kernel->getContainer()->get(\App\EventSubscriber\CommandSubscriber::class));
    }
}
