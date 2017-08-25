<?php

namespace app\controllers;

use app\forms\ProductCategoryForm;
use app\models\ProductCategory;

/**
 * Class ProductCategoryRestController
 */
class ProductCategoryRestController extends RestController
{
    protected $formType = ProductCategoryForm::class;

    protected $entityClass = ProductCategory::class;
}