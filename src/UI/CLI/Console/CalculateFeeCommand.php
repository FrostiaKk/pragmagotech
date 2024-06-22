<?php

namespace App\UI\CLI\Console;

use App\Application\Service\CalculateFeeService;
use App\Infrastructure\Persistence\InMemoryFeeRepository;
use App\Domain\Model\Fee\FeeCalculator;

class CalculateFeeCommand
{
    public static function main()
    {
        $amount = '12000.50';
        $term = 24;

        $feeRepository = new InMemoryFeeRepository();
        $feeCalculator = new FeeCalculator($feeRepository);
        $calculateFeeService = new CalculateFeeService($feeCalculator);

        $fee = $calculateFeeService->execute($amount, $term);

        echo "The calculated fee is: " . $fee;
    }
}