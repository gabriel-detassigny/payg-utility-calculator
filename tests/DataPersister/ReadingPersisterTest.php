<?php

namespace GabrielDeTassigny\Puc\Tests\DataPersister;

use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use GabrielDeTassigny\Puc\DataPersister\ReadingPersister;
use GabrielDeTassigny\Puc\Entity\Utility;
use Phake;
use PHPUnit\Framework\TestCase;

class ReadingPersisterTest extends TestCase
{
    private const TOP_UP = 5.0;
    private const AMOUNT = 10.0;

    private EntityManagerInterface $entityManager;

    /** @var ReadingPersister */
    private ReadingPersister $readingPersister;

    protected function setUp(): void
    {
        $this->entityManager = Phake::mock(EntityManagerInterface::class);
        $this->readingPersister = new ReadingPersister($this->entityManager);
    }

    public function testAddReading(): void
    {
        $utility = Phake::mock(Utility::class);

        $reading = $this->readingPersister->addReading($utility, self::AMOUNT, self::TOP_UP);

        Phake::inOrder(
            Phake::verify($this->entityManager)->persist($reading),
            Phake::verify($this->entityManager)->flush()
        );

        $this->assertSame(self::TOP_UP, $reading->getTopUp());
        $this->assertSame(self::AMOUNT, $reading->getAmount());
        $this->assertSame($utility, $reading->getUtility());
        $this->assertInstanceOf(DateTime::class, $reading->getAdded());
    }
}
