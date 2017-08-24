<?php

require '../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use app\Base;

$routes        = include __DIR__ . '/../config/routes.php';
$entityManager = include __DIR__ . '/../config/db.php';

$request = Request::createFromGlobals();

$context = new Routing\RequestContext();
$matcher = new Routing\Matcher\UrlMatcher($routes, $context);

$controllerResolver = new ControllerResolver();
$argumentResolver   = new ArgumentResolver();

$framework = new Base($matcher, $controllerResolver, $argumentResolver);
$response  = $framework->handle($request);

$response->send();