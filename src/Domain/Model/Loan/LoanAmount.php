<?php

namespace App\Domain\Model\Loan;

use App\Domain\Model\Shared\Money;
use Decimal\Decimal;
use InvalidArgumentException;

class LoanAmount extends Money
{
    public function __construct(Decimal $amount)
    {
        if ($amount < new Decimal('1000') || $amount > new Decimal('20000')) {
            throw new InvalidArgumentException('Amount must be between 1000 and 20000.');
        }

        parent::__construct($amount);
    }
}
