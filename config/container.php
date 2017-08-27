<?php

use Symfony\Component\DependencyInjection;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpFoundation;
use Symfony\Component\HttpKernel;
use Symfony\Component\Routing;
use Symfony\Component\EventDispatcher;
use app\Base;
use app\services\Doctrine;

$routes = include __DIR__ . '/../config/routes.php';
$db     = include __DIR__ . '/../config/db.php';

$containerBuilder = new DependencyInjection\ContainerBuilder();

$containerBuilder->register('context', Routing\RequestContext::class);
$containerBuilder->register('matcher', Routing\Matcher\UrlMatcher::class)
                 ->setArguments([$routes, new Reference('context')]);

$containerBuilder->register('request_stack', HttpFoundation\RequestStack::class);
$containerBuilder->register('controller_resolver', \app\services\ControllerResolver::class)
                 ->setArguments([$containerBuilder]);
$containerBuilder->register('argument_resolver', HttpKernel\Controller\ArgumentResolver::class);

$containerBuilder->register('listener.router', HttpKernel\EventListener\RouterListener::class)
                 ->setArguments([new Reference('matcher'), new Reference('request_stack')]);
$containerBuilder->register('listener.response', HttpKernel\EventListener\ResponseListener::class)
                 ->setArguments(['UTF-8']);
$containerBuilder->register('dispatcher', EventDispatcher\EventDispatcher::class)
                 ->addMethodCall('addSubscriber', [new Reference('listener.router')])
                 ->addMethodCall('addSubscriber', [new Reference('listener.response')]);

$containerBuilder->register('base', Base::class)
                 ->setArguments([
                                    new Reference('dispatcher'),
                                    new Reference('controller_resolver'),
                                    new Reference('request_stack'),
                                    new Reference('argument_resolver'),
                                ]);

$containerBuilder->register('doctrine', Doctrine::class)
                 ->setArguments($db);

$containerBuilder->register('authorization', \app\services\BearerAuthorization::class)
                 ->setArguments([
                                    'token',
                                    new Reference('doctrine')
                                ]);

return $containerBuilder;