<?php

use Symfony\Component\Routing;

$routes = new Routing\RouteCollection();

//Product
$routes->add('product.list',
             new Routing\Route('/product', [
                 '_controller' => 'app\controllers\ProductRestController::listAction',
                 'id' => null,
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

$routes->add('product.set_category',
             new Routing\Route('/product/set-category/{id}', [
                 '_controller' => 'app\controllers\ProductRestController::setCategoryAction',
             ], [], [], '', [], ['PUT']));

$routes->add('product.delete',
             new Routing\Route('/product/{id}', [
                 '_controller' => 'app\controllers\ProductRestController::deleteAction',
             ], [], [], '', [], ['DELETE']));

//ProductCategory
$routes->add('category.list',
             new Routing\Route('/category', [
                 '_controller' => 'app\controllers\CategoryRestController::listAction',
             ], [], [], '', [], ['GET']));

$routes->add('category.get',
             new Routing\Route('/category/{id}', [
                 '_controller' => 'app\controllers\CategoryRestController::getAction',
             ], [], [], '', [], ['GET']));

$routes->add('category.post',
             new Routing\Route('/category', [
                 '_controller' => 'app\controllers\CategoryRestController::postAction',
             ], [], [], '', [], ['POST']));

$routes->add('category.put',
             new Routing\Route('/category/{id}', [
                 '_controller' => 'app\controllers\CategoryRestController::putAction',
             ], [], [], '', [], ['PUT']));

$routes->add('category.delete',
             new Routing\Route('/category/{id}', [
                 '_controller' => 'app\controllers\CategoryRestController::deleteAction',
             ], [], [], '', [], ['DELETE']));

$routes->add('category.products',
             new Routing\Route('/category/{id}/products', [
                 '_controller' => 'app\controllers\CategoryRestController::getProductsAction',
             ], [], [], '', [], ['GET']));

return $routes;