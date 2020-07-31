<?php

namespace GabrielDeTassigny\Puc\Command\Reading;

use GabrielDeTassigny\Puc\DataProvider\ReadingProvider;
use GabrielDeTassigny\Puc\DataProvider\UtilityProvider;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ListCommand extends Command
{
    private const DEFAULT_LIMIT = 10;

    private ReadingProvider $readingProvider;
    private UtilityProvider $utilityProvider;

    public function __construct(ReadingProvider $readingProvider, UtilityProvider $utilityProvider)
    {
        parent::__construct();

        $this->readingProvider = $readingProvider;
        $this->utilityProvider = $utilityProvider;
    }

    public function configure()
    {
        $this->setDescription('List the latest meter readings of a given utility')
            ->setName('reading:list')
            ->addArgument('utility', InputArgument::REQUIRED, 'The utility\'s name')
            ->addOption(
                'limit',
                null,
                InputOption::VALUE_REQUIRED,
                'The maximum number of readings returned (Default: ' . self::DEFAULT_LIMIT . ')'
            );
    }

    /**
     * {@inheritDoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $limit = (int) ($input->getOption('limit') ?? self::DEFAULT_LIMIT);

        $utility = $this->utilityProvider->getByName($input->getArgument('utility'));

        $utilities = $this->readingProvider->findLatestReadings($utility, $limit);

        $output->writeln('<info>Latest ' . $utility->getName() . ' readings:</info>');
        $output->writeln("<info>Added\t\t\tAmount\tTop Up</info>");

        foreach ($utilities as $utility) {
            $output->write($utility->getAdded()->format('Y-m-d H:i:s') . "\t");
            $output->write($utility->getAmount() . "\t");
            $output->writeln($utility->getTopUp());
        }

        return Command::SUCCESS;
    }
}