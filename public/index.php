<?php

require '../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;

$routes        = include __DIR__ . '/../config/routes.php';
$entityManager = include __DIR__ . '/../config/db.php';

$container = include __DIR__ . '/../config/container.php';

$request = Request::createFromGlobals();

/**
 * @var \Symfony\Component\HttpFoundation\Response $response
 */
$response = $container->get('base')->handle($request);

$response->send();