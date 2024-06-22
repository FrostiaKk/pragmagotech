<?php

namespace App\UI\CLI\Console;

use App\Application\Service\CalculateFeeService;

class CalculateFeeCommand
{
    private CalculateFeeService $calculateFeeService;

    public function __construct(CalculateFeeService $calculateFeeService)
    {
        $this->calculateFeeService = $calculateFeeService;
    }

    public function execute(string $amount, int $term): void
    {
        $fee = $this->calculateFeeService->execute($amount, $term);

        echo "The calculated fee is: $fee" . PHP_EOL;
    }
}