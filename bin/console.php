#!/usr/bin/env php
<?php declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

$container = $container = App\Bootstrap::boot()->createContainer();

// Run symfony application.
$app = $container->getByType(\Symfony\Component\Console\Application::class);
$entityManager = $container->getByType(\VstupniTest\Factory\DoctrineFactory::class)->createEntityManagerBySettings();
$ormHelperSet = \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);
$app->setHelperSet($ormHelperSet);
//$dbalHelperSet = \Doctrine\DBAL\Tools\Console\ConsoleRunner::createHelperSet($entityManager->getConnection());
//$app->setHelperSet($dbalHelperSet);

\Doctrine\ORM\Tools\Console\ConsoleRunner::addCommands($app);
// \Doctrine\DBAL\Tools\Console\ConsoleRunner::addCommands($app);

$app->setCatchExceptions(false);
// Ensure exit codes
exit($app->run());
