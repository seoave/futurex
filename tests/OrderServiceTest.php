<?php
declare(strict_types=1);

namespace App\Tests;

use App\Repository\OfferRepository;
use App\Service\OrderService;
use PHPUnit\Framework\TestCase;

class OrderServiceTest extends TestCase
{
    public function testGetOffer(): void
    {
        $offerRepository = $this->createMock(OfferRepository::class);
        $service = new OrderService($offerRepository);
        $getOffer = $service->getOffer(6);
        $this->assertNull($getOffer);
    }
}
