<?php

namespace GabrielDeTassigny\Puc\Command\Utility;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListUtilityCommand extends Command
{
    public function configure()
    {
        $this->setDescription('List available utilities')
            ->setName('utility:list');
    }

    /**
     * {@inheritDoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        return Command::SUCCESS;
    }
}