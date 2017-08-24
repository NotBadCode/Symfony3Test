<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$isDevMode = true;
$config    = Setup::createAnnotationMetadataConfiguration([__DIR__ . "../app/models"], $isDevMode);

$connectionParams = [
    'dbname'   => 'mydb',
    'user'     => 'root',
    'password' => 'news',
    'host'     => 'localhost',
    'driver'   => 'pdo_mysql',
];

$entityManager = EntityManager::create($connectionParams, $config);

return $entityManager;