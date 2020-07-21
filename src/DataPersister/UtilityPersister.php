<?php

namespace GabrielDeTassigny\Puc\DataPersister;

use Doctrine\ORM\EntityManagerInterface;
use GabrielDeTassigny\Puc\Entity\Utility;

class UtilityPersister
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createUtility(string $name): Utility
    {
        $utility = new Utility();
        $utility->setName($name);

        $this->entityManager->persist($utility);
        $this->entityManager->flush();

        return $utility;
    }
}