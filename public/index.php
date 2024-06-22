<?php
declare(strict_types=1);

use App\UI\CLI\Console\CalculateFeeCommand;
use DI\ContainerBuilder;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions(__DIR__ . '/../config/container.php');
$container = $containerBuilder->build();

$calculateFeeCommand = $container->get(CalculateFeeCommand::class);

$amount = '12000.50';
$term = 24;

$calculateFeeCommand->execute($amount, $term);