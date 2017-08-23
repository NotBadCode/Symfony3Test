<?php

namespace app\controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use app\models\Product;

/**
 * Class ProductController
 */
class ProductController
{
    public function indexAction(Request $request)
    {
        return new Response('Nope');
    }
}