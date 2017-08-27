<?php

namespace app\controllers;

use app\forms\CategoryForm;
use app\models\Category;
use app\models\Product;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CategoryRestController
 */
class CategoryRestController extends RestController
{
    protected $formType = CategoryForm::class;

    protected $entityClass = Category::class;

    /**
     * @param Request $request
     * @param integer $id
     * @return JsonResponse
     */
    public function getProductsAction(Request $request, $id)
    {
        $category = $this->getRepository()->find($id);

        if (null === $category) {
            return new JsonResponse(['result' => false], 405);
        }

        $offset = $request->headers->get('offset', 0);
        $limit  = $request->headers->get('limit', 10);

        $repository = $this->entityManager->getRepository(Product::class);
        $qb         = $repository->createQueryBuilder('prod');
        $qb->join('prod.categories', 'cat')
           ->where($qb->expr()->eq('cat.id', $id))
           ->setFirstResult($offset)
           ->setMaxResults($limit);
        $result = $qb->getQuery()->execute();

        return new JsonResponse($result);
    }
}