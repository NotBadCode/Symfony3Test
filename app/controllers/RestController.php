<?php

namespace app\controllers;

use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\FormFactoryInterface;

use Symfony\Component\Form\Forms;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Validation;

abstract class RestController
{
    use ContainerAwareTrait;

    /**
     * @var \Symfony\Component\Form\FormFactoryInterface
     */
    protected $formFactory;

    /**
     * @var string
     */
    protected $formType;

    /**
     * @var string
     */
    protected $entityClass;

    /**
     * @var EntityManager
     */
    protected $entityManager;


    public function __construct()
    {
        $container = include __DIR__ . '/../../config/container.php';
        $this->setContainer($container);
        $this->formFactory = Forms::createFormFactoryBuilder()
                                  ->addExtension(
                                      new ValidatorExtension(Validation::createValidator()))
                                  ->getFormFactory();

        $this->entityManager = $this->container->get('doctrine')->entityManager;
    }

    /**
     * @param null  $data
     * @param array $options
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createForm($data = null, $options = [])
    {
        return $this->formFactory->create($this->formType, $data, $options);
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getRepository()
    {
        return $this->getEntityManager()->getRepository($this->entityClass);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function listAction(Request $request)
    {
        $offset = $request->headers->get('offset', 0);
        $limit  = $request->headers->get('limit', 10);

        $result = $this->getRepository()->findBy(
            [],
            null,
            $limit,
            $offset
        );

        return new JsonResponse($result);
    }

    /**
     * @param integer $id
     * @return JsonResponse
     */
    public function getAction($id)
    {
        $object = $this->getRepository()->find($id);

        if (!$object) {
            throw new NotFoundHttpException(sprintf('%s#%s not found', $this->entityClass, $id));
        }

        return new JsonResponse($object);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function postAction(Request $request)
    {
        $object = new $this->entityClass();

        $form = $this->createForm($object);
        $form->submit($request);

        if ($form->isValid()) {
            $this->getEntityManager()->persist($object);
            $this->getEntityManager()->flush($object);

            $result = $object;
        } else {
            $result = (string)$form->getErrors(true);
        }

        return new JsonResponse($result);
    }

    /**
     * @param Request  $request
     * @param  integer $id
     * @return JsonResponse
     */
    public function putAction(Request $request, $id)
    {
        $object = $this->getRepository()->find($id);

        if (!$object) {
            throw new NotFoundHttpException(sprintf('%s#%s not found', $this->entityClass, $id));
        }

        $form = $this->createForm($object);
        $form->submit($request);

        if ($form->isValid()) {
            $this->getEntityManager()->persist($object);
            $this->getEntityManager()->flush($object);

            $result = $object;
        } else {
            $result = $form->getErrors();
        }

        return new JsonResponse($result);
    }

    /**
     * @param Request  $request
     * @param  integer $id
     * @return JsonResponse
     */
    public function patchAction(Request $request, $id)
    {
        $object = $this->getRepository()->find($id);

        if (!$object) {
            throw new NotFoundHttpException(sprintf('%s#%s not found', $this->entityClass, $id));
        }

        $form = $this->createForm($object);
        $form->submit($request, false);

        if ($form->isValid()) {
            $this->getEntityManager()->persist($object);
            $this->getEntityManager()->flush($object);

            $result = $object;
        } else {
            $result = $form->getErrors();
        }

        return new JsonResponse($result);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function deleteAction($id)
    {

        $object = $this->getRepository()->find($id);

        if (!$object) {
            throw new NotFoundHttpException(sprintf('%s#%s not found', $this->entityClass, $id));
        }

        $this->getEntityManager()->remove($object);
        $this->getEntityManager()->flush($object);

        return new JsonResponse(['success' => true]);
    }

}