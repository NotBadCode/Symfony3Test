<?php

use Symfony\Component\Routing;

$routes = new Routing\RouteCollection();

$routes->add('product_index',
             new Routing\Route('/product', [
                 '_controller' => 'app\controllers\ProductController::indexAction',
             ]));

return $routes;