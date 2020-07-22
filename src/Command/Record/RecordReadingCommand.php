<?php

namespace GabrielDeTassigny\Puc\Command\Record;

use GabrielDeTassigny\Puc\DataPersister\ReadingPersister;
use GabrielDeTassigny\Puc\DataProvider\UtilityProvider;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RecordReadingCommand extends Command
{
    private ReadingPersister $readingPersister;
    private UtilityProvider $utilityProvider;

    public function __construct(ReadingPersister $readingPersister, UtilityProvider $utilityProvider)
    {
        parent::__construct();

        $this->readingPersister = $readingPersister;
        $this->utilityProvider = $utilityProvider;
    }

    public function configure()
    {
        $this->setDescription('Record a meter reading')
            ->setName('record:reading')
            ->addArgument('utility', InputArgument::REQUIRED, 'The utility\'s name')
            ->addArgument('amount', InputArgument::REQUIRED, 'The amount to record');
    }

    /**
     * {@inheritDoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $amount = (float) $input->getArgument('amount');
        $utilityName = $input->getArgument('utility');

        $utility = $this->utilityProvider->getByName($utilityName);
        $this->readingPersister->addReading($utility, $amount);

        return Command::SUCCESS;
    }
}