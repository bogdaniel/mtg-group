<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateBundleCommand extends Command
{
    protected static $defaultName = 'app:generate-bundle';

    protected function configure()
    {
        $this
            ->setDescription('Generates a new bundle.')
            ->setHelp('This command allows you to generate a new Symfony bundle...');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Get the name of the bundle from the input (you might want to add an argument to the command for this)
        $bundleName = $input->getArgument('bundleName');

        // Create the bundle directory
        mkdir(__DIR__ . "/../Bundle/$bundleName");

        // Generate the required classes (this is just a basic example, you might need to generate more classes or files depending on your needs)
        file_put_contents(__DIR__ . "/../Bundle/$bundleName/$bundleName.php", "<?php\n\nnamespace App\Bundle\\$bundleName;\n\nuse Symfony\Component\HttpKernel\Bundle\Bundle;\n\nclass $bundleName extends Bundle\n{\n}\n");

        // Register the bundle in config/bundles.php
        $bundles = require __DIR__ . '/../../config/bundles.php';
        $bundles["App\\Bundle\\$bundleName\\$bundleName"] = ['all' => true];
        file_put_contents(__DIR__ . '/../../config/bundles.php', "<?php\n\nreturn " . var_export($bundles, true) . ";\n");

        $output->writeln('Bundle generated and registered successfully.');

        return Command::SUCCESS;
    }
}
