<?php
declare(strict_types=1);

namespace App\Tests;

use App\Repository\OfferRepository;
use App\Service\OfferService;
use PHPUnit\Framework\TestCase;

class OfferServiceTest extends TestCase
{
    public function testCloseStatusSelector()
    {
        $offerRepository = $this->createMock(OfferRepository::class);
        $service = new OfferService($offerRepository);
        $result = $service->statusSelector(1, 1);
        $result2 = $service->statusSelector(1, 0);
        $result3 = $service->statusSelector(2, 1);
        self::assertIsString($result);
        self::assertIsString($result2);
        self::assertIsString($result3);
    }
}
