<?php

namespace App\UI\CLI\Console;

use App\Application\Service\CalculateFeeService;
use Throwable;

class CalculateFeeCommand
{
    public function __construct(private readonly CalculateFeeService $calculateFeeService)
    {
    }

    public function execute(string $amount, int $term): void
    {
        try {
            $fee = $this->calculateFeeService->execute($amount, $term);
        } catch (Throwable $exception) {
            echo sprintf('Error: %s', $exception->getMessage()) . PHP_EOL;
        }

        echo "The calculated fee is: $fee" . PHP_EOL;
    }
}
