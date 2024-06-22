<?php

namespace App\Domain\Model\Shared;

use Decimal\Decimal;

class Money
{
    public function __construct(private readonly Decimal $amount)
    {
    }

    public function getAmount(): Decimal
    {
        return $this->amount;
    }

    public function add(Money $money): Money
    {
        return new Money($this->amount->add($money->getAmount()));
    }

    public function roundUpToNearestFive(): Money
    {
        $rounded = $this->amount->div(5)->ceil()->mul(5);

        return new Money($rounded);
    }
}
