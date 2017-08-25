<?php

use Symfony\Component\Routing;

$routes = new Routing\RouteCollection();

$routes->add('product.list',
             new Routing\Route('/product', [
                 '_controller' => 'app\controllers\ProductRestController::listAction',
             ], [], [], '', [], ['GET']));

$routes->add('product.get',
             new Routing\Route('/product/{id}', [
                 '_controller' => 'app\controllers\ProductRestController::getAction',
             ], [], [], '', [], ['GET']));

$routes->add('product.post',
             new Routing\Route('/product', [
                 '_controller' => 'app\controllers\ProductRestController::postAction',
             ], [], [], '', [], ['POST']));

$routes->add('product.put',
             new Routing\Route('/product/{id}', [
                 '_controller' => 'app\controllers\ProductRestController::putAction',
             ], [], [], '', [], ['PUT']));

$routes->add('product.delete',
             new Routing\Route('/product/{id}', [
                 '_controller' => 'app\controllers\ProductRestController::deleteAction',
             ], [], [], '', [], ['DELETE']));


$routes->add('product.category.list',
             new Routing\Route('/product-category', [
                 '_controller' => 'app\controllers\ProductCategoryRestController::listAction',
             ], [], [], '', [], ['GET']));

$routes->add('product.category.get',
             new Routing\Route('/product-category/{id}', [
                 '_controller' => 'app\controllers\ProductCategoryRestController::getAction',
             ], [], [], '', [], ['GET']));

$routes->add('product.category.post',
             new Routing\Route('/product-category', [
                 '_controller' => 'app\controllers\ProductCategoryRestController::postAction',
             ], [], [], '', [], ['POST']));

$routes->add('product.category.put',
             new Routing\Route('/product-category/{id}', [
                 '_controller' => 'app\controllers\ProductCategoryRestController::putAction',
             ], [], [], '', [], ['PUT']));

$routes->add('product.category.delete',
             new Routing\Route('/product-category/{id}', [
                 '_controller' => 'app\controllers\ProductCategoryRestController::deleteAction',
             ], [], [], '', [], ['DELETE']));

return $routes;