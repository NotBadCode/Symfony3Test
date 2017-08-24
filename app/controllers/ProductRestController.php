<?php

namespace app\controllers;

/**
 * Class ProductRestController
 */
class ProductRestController extends RestController
{
    protected $formType;

    protected $entityClass = \app\models\Product::class;
}