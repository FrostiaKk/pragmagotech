<?php
declare(strict_types=1);

use App\UI\CLI\Console\CalculateFeeCommand;

require_once dirname(__DIR__) . '/vendor/autoload.php';

CalculateFeeCommand::main();