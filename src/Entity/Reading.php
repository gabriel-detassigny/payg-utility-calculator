<?php

namespace GabrielDeTassigny\Puc\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use GabrielDeTassigny\Puc\Repository\ReadingRepository;

/**
 * @ORM\Entity(repositoryClass=ReadingRepository::class)
 * @ORM\Table(name="readings")
 */
class Reading
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private int $id;

    /**
     * @ORM\Column(type="float")
     */
    private float $topUp;

    /**
     * @ORM\Column(type="float")
     */
    private float $amount;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTime $added;

    /**
     * @ORM\ManyToOne(targetEntity=Utility::class)
     * @ORM\JoinColumn(name="utility_id", referencedColumnName="id")
     */
    private Utility $utility;

    public function getId(): int
    {
        return $this->id;
    }

    public function getTopUp(): float
    {
        return $this->topUp;
    }

    public function setTopUp(float $topUp): void
    {
        $this->topUp = $topUp;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    public function getAdded(): DateTime
    {
        return $this->added;
    }

    public function setAdded(DateTime $added): void
    {
        $this->added = $added;
    }

    public function getUtility(): Utility
    {
        return $this->utility;
    }

    public function setUtility(Utility $utility): void
    {
        $this->utility = $utility;
    }
}