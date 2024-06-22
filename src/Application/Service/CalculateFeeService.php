<?php

namespace App\Application\Service;

use App\Domain\Model\Fee\FeeCalculatorInterface;
use App\Domain\Model\Loan\Loan;
use App\Domain\Model\Loan\LoanAmount;
use App\Domain\Model\Loan\LoanTerm;
use Decimal\Decimal;

class CalculateFeeService
{
    public function __construct(private readonly FeeCalculatorInterface $feeCalculator)
    {
    }

    public function execute(string $amount, int $term): Decimal
    {
        $loanAmount = new LoanAmount(new Decimal($amount));
        $loanTerm = new LoanTerm($term);
        $loan = new Loan($loanAmount, $loanTerm);

        $fee = $this->feeCalculator->calculate($loan);
        return $fee->getAmount();
    }
}