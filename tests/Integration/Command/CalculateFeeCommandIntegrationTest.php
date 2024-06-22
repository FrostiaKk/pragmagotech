<?php

namespace App\Tests\Integration\Command;

use App\Application\Service\CalculateFeeService;
use App\Tests\AppTest;
use App\UI\CLI\Console\CalculateFeeCommand;

class CalculateFeeCommandIntegrationTest extends AppTest
{
    public function testCalculateFeeCommand()
    {
        $command = new CalculateFeeCommand($this->getContainer()->get(CalculateFeeService::class));

        ob_start();
        $command->execute('12000.50', 24);
        $output = ob_get_clean();

        $this->assertStringContainsString('The calculated fee is: 484.50', $output);
    }

    public function testCalculateFeeCommandIncorrectAmountError()
    {
        $command = new CalculateFeeCommand($this->getContainer()->get(CalculateFeeService::class));

        ob_start();
        $command->execute('2', 24);
        $output = ob_get_clean();

        $this->assertStringContainsString('Error: Amount must be between 1000 and 20000.', $output);
    }
}