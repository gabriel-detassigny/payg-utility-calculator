<?php

namespace GabrielDeTassigny\Puc\DataProvider;

use GabrielDeTassigny\Puc\Entity\Utility;
use GabrielDeTassigny\Puc\Repository\UtilityRepository;
use RuntimeException;

class UtilityProvider
{
    private UtilityRepository $utilityRepository;

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

    public function getByName(string $name): Utility
    {
        /** @var Utility|null $utility */
        $utility = $this->utilityRepository->findOneBy(['name' => $name]);

        if (is_null($utility)) {
            throw new RuntimeException('No utility found with name: ' . $name);
        }

        return $utility;
    }
}