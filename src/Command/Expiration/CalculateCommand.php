<?php

namespace GabrielDeTassigny\Puc\Command\Expiration;

use GabrielDeTassigny\Puc\DataProvider\ReadingProvider;
use GabrielDeTassigny\Puc\DataProvider\UtilityProvider;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CalculateCommand extends Command
{
    private UtilityProvider $utilityProvider;
    private ReadingProvider $readingProvider;

    public function __construct(UtilityProvider $utilityProvider, ReadingProvider $readingProvider)
    {
        parent::__construct();

        $this->utilityProvider = $utilityProvider;
        $this->readingProvider = $readingProvider;
    }

    public function configure()
    {
        $this->setDescription('Calculate the day your utility credit might expire')
            ->setName('expiration:calculate')
            ->addArgument('utility', InputArgument::REQUIRED, 'The utility\'s name');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $utility = $this->utilityProvider->getByName($input->getArgument('utility'));

        $expiration = $this->readingProvider->calculateExpiration($utility);

        $output->writeln($utility->getName() . ' will expire on ' . $expiration->format('d/m/Y'));

        return Command::SUCCESS;
    }
}