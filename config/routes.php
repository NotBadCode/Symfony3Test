<?php

use Symfony\Component\Routing;

$routes = new Routing\RouteCollection();

$routes->add('product',
             new Routing\Route('/product', [
                 '_controller' => 'app\controllers\ProductRestController::listAction',
             ]));

return $routes;