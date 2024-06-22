<?php
declare(strict_types=1);

use App\Application\Service\CalculateFeeService;
use App\Domain\Model\Fee\FeeCalculator;
use App\Infrastructure\Persistence\InMemoryFeeRepository;
use App\UI\CLI\Console\CalculateFeeCommand;
use DI\ContainerBuilder;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$containerBuilder = new ContainerBuilder();
$container = $containerBuilder->build();

$container->set(InMemoryFeeRepository::class, function () {
    return new InMemoryFeeRepository();
});

$container->set(FeeCalculator::class, function ($container) {
    $feeRepository = $container->get('App\Infrastructure\Persistence\InMemoryFeeRepository');
    return new FeeCalculator($feeRepository);
});

$container->set(CalculateFeeService::class, function ($container) {
    $feeCalculator = $container->get('App\Domain\Model\Fee\FeeCalculator');
    return new CalculateFeeService($feeCalculator);
});

$calculateFeeCommand = $container->get(CalculateFeeCommand::class);

$amount = '12000.50';
$term = 24;

$calculateFeeCommand->execute($amount, $term);