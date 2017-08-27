<?php

namespace app\controllers;

use app\forms\ProductForm;
use app\models\Product;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ProductRestController
 */
class ProductRestController extends RestController
{

    protected $formType = ProductForm::class;

    protected $entityClass = Product::class;
}