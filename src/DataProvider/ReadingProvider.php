<?php

namespace GabrielDeTassigny\Puc\DataProvider;

use DateTime;
use GabrielDeTassigny\Puc\Entity\Reading;
use GabrielDeTassigny\Puc\Entity\Utility;
use GabrielDeTassigny\Puc\Repository\ReadingRepository;
use RuntimeException;

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

    public function calculateExpiration(Utility $utility): DateTime
    {
        [$latest, $previous] = $this->getLatestTwoReadings($utility);

        $timeDifference = $this->getPreviousTimeDifferenceInSec($latest->getAdded(), $previous->getAdded());
        $amountDifference = $previous->getAmount() - ($latest->getAmount() - $latest->getTopUp());

        $expirationInSec = (int) ($timeDifference / $amountDifference * $latest->getAmount());

        $expirationTime = new DateTime();
        $expirationTime->setTimestamp($latest->getAdded()->getTimestamp() + $expirationInSec);

        return $expirationTime;
    }

    /**
     * @param Utility $utility
     * @return Reading[]
     */
    private function getLatestTwoReadings(Utility $utility): array
    {
        $readings = $this->findLatestReadings($utility, 2);

        if (count($readings) < 2) {
            throw new RuntimeException('Not enough data to predict the expiration. Please add more readings!');
        }

        return $readings;
    }

    private function getPreviousTimeDifferenceInSec(DateTime $latest, DateTime $previous): int
    {
        return $latest->getTimestamp() - $previous->getTimestamp();
    }
}