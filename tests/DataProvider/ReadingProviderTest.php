<?php

namespace GabrielDeTassigny\Puc\Tests\DataProvider;

use DateTime;
use GabrielDeTassigny\Puc\DataProvider\ReadingProvider;
use GabrielDeTassigny\Puc\Entity\Reading;
use GabrielDeTassigny\Puc\Entity\Utility;
use GabrielDeTassigny\Puc\Repository\ReadingRepository;
use Phake;
use PHPUnit\Framework\TestCase;

class ReadingProviderTest extends TestCase
{
    private const UTILITY_ID = 1;

    private ReadingRepository $readingRepository;

    /** @var ReadingProvider */
    private ReadingProvider $readingProvider;

    private Utility $utility;

    protected function setUp(): void
    {
        $this->utility = Phake::mock(Utility::class);
        Phake::when($this->utility)->getId()->thenReturn(self::UTILITY_ID);

        $this->readingRepository = Phake::mock(ReadingRepository::class);
        $this->readingProvider = new ReadingProvider($this->readingRepository);
    }

    public function testFindLatestReadings(): void
    {
        $readings = [Phake::mock(Reading::class)];

        Phake::when($this->readingRepository)->findBy(
            ['utility' => self::UTILITY_ID],
            ['added' => 'desc'],
            10
        )->thenReturn($readings);

        $this->assertSame($readings, $this->readingProvider->findLatestReadings($this->utility, 10));
    }

    /**
     * @dataProvider expirationProvider
     */
    public function testCalculateExpiration(
        string $latestTime,
        float $latestAmount,
        float $latestTopUp,
        string $previousTime,
        float $previousAmount,
        string $expectedTime
    ) {
        $latestReading = new Reading();
        $latestReading->setAdded(new DateTime($latestTime));
        $latestReading->setAmount($latestAmount);
        $latestReading->setTopUp($latestTopUp);

        $previousReading = new Reading();
        $previousReading->setAdded(new DateTime($previousTime));
        $previousReading->setAmount($previousAmount);

        Phake::when($this->readingRepository)->findBy(
            ['utility' => self::UTILITY_ID],
            ['added' => 'desc'],
            2
        )->thenReturn([$latestReading, $previousReading]);


        $expirationTime = $this->readingProvider->calculateExpiration($this->utility);

        $this->assertSame($expectedTime, $expirationTime->format('Y-m-d H:i:s'));
    }

    public function expirationProvider(): array
    {
        return [
            ['2020-01-02 00:00:00', 20, 10, '2020-01-01 00:00:00', 20, '2020-01-04 00:00:00']
        ];
    }
}
