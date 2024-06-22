<?php

namespace App\Domain\Model\Fee;

use App\Domain\Model\Loan\Loan;

interface FeeCalculatorInterface
{
    public function calculate(Loan $loan): Fee;
}