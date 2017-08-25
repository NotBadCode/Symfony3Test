<?php

namespace app\controllers;

use app\forms\ProductForm;
use app\models\Product;

/**
 * Class ProductRestController
 */
class ProductRestController extends RestController
{
    protected $formType = ProductForm::class;

    protected $entityClass = Product::class;
}