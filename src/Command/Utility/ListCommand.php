<?php

namespace GabrielDeTassigny\Puc\Command\Utility;

use GabrielDeTassigny\Puc\DataProvider\UtilityProvider;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListCommand extends Command
{
    private UtilityProvider $utilityProvider;

    public function __construct(UtilityProvider $utilityProvider)
    {
        parent::__construct();

        $this->utilityProvider = $utilityProvider;
    }

    public function configure()
    {
        $this->setDescription('List available utilities')
            ->setName('utility:list');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $utilities = $this->utilityProvider->findAll();

        $output->writeln('<info>Available utilities:</info>');

        foreach ($utilities as $utility) {
            $output->writeln($utility->getName());
        }

        return Command::SUCCESS;
    }
}