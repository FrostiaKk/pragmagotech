<?php

namespace App\Domain\Model\Fee;

use Decimal\Decimal;

interface FeeRepositoryInterface
{
    public function getBreakpointHigherThan(int $term, Decimal $amount): ?FeeBreakpoint;

    public function getBreakpointLowerThan(int $term, Decimal $amount): ?FeeBreakpoint;
}