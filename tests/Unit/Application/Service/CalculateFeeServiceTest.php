<?php

namespace App\Tests\Unit\Application\Service;

use App\Application\Service\CalculateFeeService;
use App\Domain\Model\Fee\Fee;
use App\Domain\Model\Fee\FeeCalculatorInterface;
use Decimal\Decimal;
use PHPUnit\Framework\TestCase;

class CalculateFeeServiceTest extends TestCase
{
    private CalculateFeeService $calculateFeeService;

    protected function setUp(): void
    {
        parent::setUp();

        $feeCalculator = $this->createMock(FeeCalculatorInterface::class);

        $feeCalculator->method('calculate')
            ->willReturn(new Fee(new Decimal('484.50')));

        $this->calculateFeeService = new CalculateFeeService($feeCalculator);
    }

    public function testCalculateFee()
    {
        $amount = '12000.50';
        $term = 24;

        $fee = $this->calculateFeeService->execute($amount, $term);

        $this->assertEquals('484.50' , $fee->toString());
    }
}