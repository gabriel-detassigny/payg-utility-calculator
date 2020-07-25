<?php

namespace GabrielDeTassigny\Puc\DataProvider;

use GabrielDeTassigny\Puc\Entity\Reading;
use GabrielDeTassigny\Puc\Entity\Utility;
use GabrielDeTassigny\Puc\Repository\ReadingRepository;

class ReadingProvider
{
    private ReadingRepository $readingRepository;

    public function __construct(ReadingRepository $readingRepository)
    {
        $this->readingRepository = $readingRepository;
    }

    /**
     * @param Utility $utility
     * @param int $limit
     * @return Reading[]
     */
    public function findLatestReadings(Utility $utility, int $limit): array
    {
       return $this->readingRepository->findBy(
           ['utility' => $utility->getId()],
           ['added' => 'desc'],
           $limit
       );
    }
}