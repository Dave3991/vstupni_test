#!/usr/bin/env php
<?php declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

$container = $container = App\Bootstrap::boot()->createContainer();

// Run symfony application.
$app = $container->getByType(\Symfony\Component\Console\Application::class);

// Ensure exit codes
exit($app->run());
