<?php

namespace App\Tests;

use App\Service\ReservationService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ResaTest extends KernelTestCase
{

    public function testSomething(): void
    {
        $kernel = self::bootKernel();
        $reservationService = $kernel->getContainer()->get(ReservationService::class);


        $debut = \DateTime::createFromFormat("d-m-Y H:i:s", '10-04-2023 12:00:00');
        $fin = \DateTime::createFromFormat("d-m-Y H:i:s", '10-04-2023 13:00:00');
        $reservationService->rechercherDispos($debut, $fin, 5);
    }
}
