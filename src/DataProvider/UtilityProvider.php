<?php

namespace GabrielDeTassigny\Puc\DataProvider;

use GabrielDeTassigny\Puc\Entity\Utility;
use GabrielDeTassigny\Puc\Repository\UtilityRepository;

class UtilityProvider
{
    /** @var UtilityRepository */
    private $utilityRepository;

    public function __construct(UtilityRepository $utilityRepository)
    {
        $this->utilityRepository = $utilityRepository;
    }

    /**
     * @return Utility[]
     */
    public function findAll(): array
    {
        return $this->utilityRepository->findAll();
    }
}