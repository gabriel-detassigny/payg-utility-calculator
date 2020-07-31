<?php

namespace GabrielDeTassigny\Puc\Command\Expiration;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CalculateCommand extends Command
{
    public function configure()
    {
        $this->setDescription('Calculate the day your utility credit might expire')
            ->setName('expiration:calculate')
            ->addArgument('utility', InputArgument::REQUIRED, 'The utility\'s name');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        return Command::SUCCESS;
    }
}