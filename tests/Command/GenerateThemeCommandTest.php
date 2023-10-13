<?php

namespace App\Tests\Command;

use App\Command\GenerateThemeCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class GenerateThemeCommandTest extends KernelTestCase
{
    private $commandTester;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find('app:generate-theme');
        $this->commandTester = new CommandTester($command);
    }

    public function testExecute()
    {
        $this->commandTester->setInputs([
            'My Theme', // Theme title
            'my-theme', // Package name
            'A theme for testing', // Description
            'MIT', // License
            'https://example.com', // Homepage
            'Author 1', // Author name
            'author1@example.com', // Author email
            '', // Empty author name to stop adding authors
            '1.0.0', // Version
        ]);

        $this->commandTester->execute([]);

        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('Theme my-theme generated successfully.', $output);
    }
}
