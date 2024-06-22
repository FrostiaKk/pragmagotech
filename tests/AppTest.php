<?php

namespace App\Tests;

use DI\Container;
use DI\ContainerBuilder;
use PHPUnit\Framework\TestCase;

class AppTest extends TestCase
{
    private Container $container;

    protected function setUp(): void
    {
        parent::setUp();

        $containerBuilder = new ContainerBuilder();
        $containerBuilder->addDefinitions(dirname(__DIR__) . '/config/container.php');
        $this->container = $containerBuilder->build();
    }

    protected function getContainer(): Container
    {
        return $this->container;
    }
}
