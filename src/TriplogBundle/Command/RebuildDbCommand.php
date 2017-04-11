<?php

namespace TriplogBundle\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RebuildDbCommand extends Command
{
    protected function configure()
    {
        $this->setName('custom:rebuild-db')
            ->setDescription('Rebuild database, schema and load fixtures.')
            ->setHelp('This command allow you to recreate db, schema and load fixtures.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Drop database.
        $output->writeln(['Rebuild database...', 'Drop database...']);
        $command = $this->getApplication()->find('doctrine:database:drop');
        $arguments = [
            'command' => 'doctrine:database:drop',
            '--force' => true,
        ];
        $commandInput = new ArrayInput($arguments);
        $command->run($commandInput, $output);

        // Create database.
        $output->writeln(['Create database...']);
        $command = $this->getApplication()->find('doctrine:database:create');
        $commandInput = new ArrayInput([]);
        $command->run($commandInput, $output);

        // Create schema.
        $output->writeln(['Create schema...']);
        $command = $this->getApplication()->find('doctrine:schema:create');
        $commandInput = new ArrayInput([]);
        $command->run($commandInput, $output);

        // Load fixtures.
        $output->writeln(['Load fixtures...']);
        $command = $this->getApplication()->find('doctrine:fixtures:load');
        $commandInput = new ArrayInput([]);
        $command->run($commandInput, $output);
    }
}
