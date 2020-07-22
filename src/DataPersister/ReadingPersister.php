<?php

namespace GabrielDeTassigny\Puc\DataPersister;

use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use GabrielDeTassigny\Puc\Entity\Reading;
use GabrielDeTassigny\Puc\Entity\Utility;

class ReadingPersister
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function addReading(Utility $utility, float $amount, float $topUp = 0.0): Reading
    {
        $reading = new Reading();

        $reading->setAdded(new DateTime());
        $reading->setAmount($amount);
        $reading->setTopUp($topUp);
        $reading->setUtility($utility);

        $this->entityManager->persist($reading);
        $this->entityManager->flush();

        return $reading;
    }
}