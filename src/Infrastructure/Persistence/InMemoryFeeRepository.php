<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Model\Fee\FeeBreakpoint;
use App\Domain\Model\Fee\FeeRepositoryInterface;
use Decimal\Decimal;

class InMemoryFeeRepository implements FeeRepositoryInterface
{
    private array $breakpoints = [
        12 => [
            [1000, 50],
            [2000, 90],
            [3000, 90],
            [4000, 115],
            [5000, 100],
            [6000, 120],
            [7000, 140],
            [8000, 160],
            [9000, 180],
            [10000, 200],
            [11000, 220],
            [12000, 240],
            [13000, 260],
            [14000, 280],
            [15000, 300],
            [16000, 320],
            [17000, 340],
            [18000, 360],
            [19000, 380],
            [20000, 400],
        ],
        24 => [
            [1000, 70],
            [2000, 100],
            [3000, 120],
            [4000, 160],
            [5000, 200],
            [6000, 240],
            [7000, 280],
            [8000, 320],
            [9000, 360],
            [10000, 400],
            [11000, 440],
            [12000, 480],
            [13000, 520],
            [14000, 560],
            [15000, 600],
            [16000, 640],
            [17000, 680],
            [18000, 720],
            [19000, 760],
            [20000, 800],
        ]
    ];

    public function getBreakpointHigherThan(int $term, Decimal $amount): ?FeeBreakpoint
    {
        foreach ($this->breakpoints[$term] as $point) {
            $pointLoanAmount = new Decimal($point[0]);
            if ($pointLoanAmount > $amount) {
                return new FeeBreakpoint($pointLoanAmount, new Decimal($point[1]));
            }
        }

        return null;
    }

    public function getBreakpointLowerThan(int $term, Decimal $amount): ?FeeBreakpoint
    {
        $foundPoint = null;
        foreach ($this->breakpoints[$term] as $point) {
            if (new Decimal($point[0]) < $amount) {
                $foundPoint = $point;
            } else {
                break;
            }
        }

        if ($foundPoint) {
            return new FeeBreakpoint(new Decimal($foundPoint[0]), new Decimal($foundPoint[1]));
        }

        return null;
    }
}
