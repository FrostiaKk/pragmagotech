<?php

namespace App\Tests\Unit\Domain\Model\Fee;

use App\Domain\Model\Fee\Fee;
use App\Domain\Model\Fee\FeeBreakpoint;
use App\Domain\Model\Fee\FeeCalculator;
use App\Domain\Model\Fee\FeeCalculatorInterface;
use App\Domain\Model\Fee\FeeRepositoryInterface;
use App\Domain\Model\Loan\Loan;
use App\Domain\Model\Loan\LoanAmount;
use App\Domain\Model\Loan\LoanTerm;
use Decimal\Decimal;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class FeeCalculatorTest extends TestCase
{
    private FeeCalculatorInterface $feeCalculator;

    protected function setUp(): void
    {
        parent::setUp();
    }

    /** @dataProvider getCalculationData */
    public function testValidCalculation(LoanAmount $loanAmount, LoanTerm $loanTerm, FeeBreakpoint $lowerPoint, FeeBreakpoint $higherPoint, string $feeValue)
    {
        $feeCalculator = $this->createMock(FeeRepositoryInterface::class);

        $feeCalculator->method('getBreakpointHigherThan')
            ->willReturn($higherPoint);

        $feeCalculator->method('getBreakpointLowerThan')
            ->willReturn($lowerPoint);

        $this->feeCalculator = new FeeCalculator($feeCalculator);

        $fee = $this->runCalculator($loanAmount, $loanTerm);

        $this->assertEquals($feeValue, $fee->getAmount()->toString());
    }

    public static function getCalculationData()
    {
        yield 'withThousandTermTwelve' => [
            new LoanAmount(new Decimal('1000')),
            new LoanTerm(12),
            new FeeBreakpoint(new Decimal(1000), new Decimal(50)),
            new FeeBreakpoint(new Decimal(2000), new Decimal(90)),
            '50',
        ];

        yield 'withRandomAmountTermTwelve' => [
            new LoanAmount(new Decimal('1234.12')),
            new LoanTerm(12),
            new FeeBreakpoint(new Decimal(1000), new Decimal(50)),
            new FeeBreakpoint(new Decimal(2000), new Decimal(90)),
            '60.88',
        ];

        yield 'withTwentyThousandTermTwelve' => [
            new LoanAmount(new Decimal('20000')),
            new LoanTerm(12),
            new FeeBreakpoint(new Decimal(19000), new Decimal(380)),
            new FeeBreakpoint(new Decimal(20000), new Decimal(400)),
            '400',
        ];

        yield 'withThousandTermTwentyTwo' => [
            new LoanAmount(new Decimal('1000')),
            new LoanTerm(24),
            new FeeBreakpoint(new Decimal(1000), new Decimal(70)),
            new FeeBreakpoint(new Decimal(2000), new Decimal(100)),
            '70',
        ];

        yield 'withRandomAmountTermTwentyTwo' => [
            new LoanAmount(new Decimal('1234.12')),
            new LoanTerm(24),
            new FeeBreakpoint(new Decimal(1000), new Decimal(70)),
            new FeeBreakpoint(new Decimal(2000), new Decimal(100)),
            '80.88',
        ];

        yield 'withTwentyThousandTermTwentyTwo' => [
            new LoanAmount(new Decimal('20000')),
            new LoanTerm(24),
            new FeeBreakpoint(new Decimal(19000), new Decimal(760)),
            new FeeBreakpoint(new Decimal(20000), new Decimal(800)),
            '800',
        ];
    }

    public function testInvalidBreakpoints()
    {
        $feeCalculator = $this->createMock(FeeRepositoryInterface::class);

        $feeCalculator->method('getBreakpointHigherThan')
            ->willReturn(null);

        $feeCalculator->method('getBreakpointLowerThan')
            ->willReturn(null);

        $this->feeCalculator = new FeeCalculator($feeCalculator);

        $this->expectException(RuntimeException::class);

        $this->runCalculator();
    }

    private function runCalculator($loanAmount = null, $loanTerm = null): Fee
    {
        $loanAmount = $loanAmount ?? new LoanAmount(new Decimal(10500));
        $loanTerm = $loanTerm ?? new LoanTerm(12);

        return $this->feeCalculator->calculate(new Loan($loanAmount, $loanTerm));
    }
}
