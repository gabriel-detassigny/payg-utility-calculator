<?php

namespace GabrielDeTassigny\Puc\Command\Utility;

use GabrielDeTassigny\Puc\DataPersister\UtilityPersister;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateCommand extends Command
{
    private UtilityPersister $utilityPersister;

    public function __construct(UtilityPersister $utilityPersister)
    {
        parent::__construct();

        $this->utilityPersister = $utilityPersister;
    }

    public function configure()
    {
        $this->setDescription('Create a new utility')
            ->setName('utility:create')
            ->addArgument('name', InputArgument::REQUIRED, 'The utility\'s name');
    }

    /**
     * {@inheritDoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');

        $this->utilityPersister->createUtility($name);

        $output->writeln('<info>Utility successfully created.</info>');

        return Command::SUCCESS;
    }
}