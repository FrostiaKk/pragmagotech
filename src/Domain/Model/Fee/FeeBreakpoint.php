<?php

namespace App\Domain\Model\Fee;

use Decimal\Decimal;

class FeeBreakpoint
{
    public function __construct(private readonly Decimal $amount, private readonly Decimal $fee)
    {
    }

    public function getAmount(): Decimal
    {
        return $this->amount;
    }

    public function getFee(): Decimal
    {
        return $this->fee;
    }
}
