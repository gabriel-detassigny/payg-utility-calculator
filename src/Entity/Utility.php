<?php

namespace GabrielDeTassigny\Puc\Entity;

use Doctrine\ORM\Mapping as ORM;
use GabrielDeTassigny\Puc\Repository\UtilityRepository;

/**
 * @ORM\Entity(repositoryClass=UtilityRepository::class)
 * @ORM\Table(name="utilities")
 */
class Utility
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=false, unique=true)
     */
    private string $name;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}