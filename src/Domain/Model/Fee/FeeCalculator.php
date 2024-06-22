<?php

namespace App\Domain\Model\Fee;

use App\Domain\Model\Loan\Loan;
use Decimal\Decimal;
use RuntimeException;

use function DI\value;

class FeeCalculator implements FeeCalculatorInterface
{
    public function __construct(private readonly FeeRepositoryInterface $feeRepository)
    {
    }

    public function calculate(Loan $loan): Fee
    {
        $term = $loan->getTerm()->getTerm();
        $loanAmount = $loan->getAmount()->getAmount();

        $lowerPoint = $this->feeRepository->getBreakpointLowerThan($term->value, $loanAmount);
        $higherPoint = $this->feeRepository->getBreakpointHigherThan($term->value, $loanAmount);

        if (!$lowerPoint || !$higherPoint) {
            throw new RuntimeException('Could not find appropriate breakpoints.');
        }

        $feeAmount = $this->linearInterpolation($lowerPoint->getAmount(), $lowerPoint->getFee(), $higherPoint->getAmount(), $higherPoint->getFee(), new Decimal($loanAmount));

        $fee = new Fee($feeAmount);

        $total = $loan->getAmount()->add($fee)->roundUpToNearestFive();

        return new Fee($total->getAmount()->sub($loan->getAmount()->getAmount()));
    }

    private function linearInterpolation(Decimal $x0, Decimal $y0, Decimal $x1, Decimal $y1, Decimal $x): Decimal
    {
        return $y0->add($y1->sub($y0)->mul($x->sub($x0))->div($x1->sub($x0)));
    }
}
