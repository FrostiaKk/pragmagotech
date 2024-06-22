<?php

use App\Application\Service\CalculateFeeService;
use App\Domain\Model\Fee\FeeCalculator;
use Psr\Container\ContainerInterface;
use function DI\autowire;

return [
    'App\Infrastructure\Persistence\InMemoryFeeRepository' => autowire(App\Infrastructure\Persistence\InMemoryFeeRepository::class),
    'App\Domain\Model\Fee\FeeCalculator' => function (ContainerInterface $c) {
        $feeRepository = $c->get('App\Infrastructure\Persistence\InMemoryFeeRepository');
        return new FeeCalculator($feeRepository);
    },
    'App\Application\Service\CalculateFeeService' => function (ContainerInterface $c) {
        $feeCalculator = $c->get('App\Domain\Model\Fee\FeeCalculator');
        return new CalculateFeeService($feeCalculator);
    },
];