<?php

require_once "vendor/autoload.php";

try {
    $container = include __DIR__ . '/container.php';

    $entityManager = $container->get('doctrine')->entityManager;

    return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);
} catch (Exception $exception) {
    echo '<pre>';
    var_dump($exception->getMessage());
    echo '</pre>';
    exit;
}