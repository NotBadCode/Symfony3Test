<?php

require '../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;

try {
    $container = include __DIR__ . '/../config/container.php';

    $request = Request::createFromGlobals();

    /**
     * @var \Symfony\Component\HttpFoundation\Response $response
     */
    $response = $container->get('base')->handle($request);

    $response->send();
} catch (Exception $exception) {
    echo $exception->getMessage();
}