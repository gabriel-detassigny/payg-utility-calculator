<?php

namespace GabrielDeTassigny\Puc\Command\Reading;

use GabrielDeTassigny\Puc\DataPersister\ReadingPersister;
use GabrielDeTassigny\Puc\DataProvider\UtilityProvider;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AddReadingCommand extends Command
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
            ->setName('reading:add')
            ->addArgument('utility', InputArgument::REQUIRED, 'The utility\'s name')
            ->addArgument('amount', InputArgument::REQUIRED, 'The amount to record (after top-up, if any)')
            ->addArgument('top-up', InputArgument::OPTIONAL, 'The amount of credits added');
    }

    /**
     * {@inheritDoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->readingPersister->addReading(
            $this->utilityProvider->getByName($input->getArgument('utility')),
            (float) $input->getArgument('amount'),
            $input->hasArgument('top-up') ? (float) $input->getArgument('top-up') : 0.0
        );

        return Command::SUCCESS;
    }
}