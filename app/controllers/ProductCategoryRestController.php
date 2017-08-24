<?php

namespace app\controllers;

/**
 * Class ProductCategoryRestController
 */
class ProductCategoryRestController extends RestController
{
    protected $formType;

    protected $entityClass = \app\models\ProductCategory::class;
}