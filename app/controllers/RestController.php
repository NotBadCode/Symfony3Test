<?php

namespace app\controllers;

use app\services\BearerAuthorization;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\Forms;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Validator\Validation;

abstract class RestController implements ContainerAwareInterface
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

    /**
     * @var BearerAuthorization
     */
    protected $authorization;

    /**
     * Sets the container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;

        $this->formFactory = Forms::createFormFactoryBuilder()
                                  ->addExtension(
                                      new ValidatorExtension(Validation::createValidator()))
                                  ->getFormFactory();

        $this->entityManager = $this->container->get('doctrine')->entityManager;

        $this->authorization = $this->container->get('authorization');
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
            return new JsonResponse(['result' => false], 405);
        }

        return new JsonResponse($object);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function postAction(Request $request)
    {
        if (!$this->authorization->checkAuth($request)) {
            return new JsonResponse(['result' => false], 401);
        }

        $object = new $this->entityClass();

        $form = $this->createForm($object);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isValid()) {
            $this->getEntityManager()->persist($object);
            $this->getEntityManager()->flush($object);
        } else {
            return new JsonResponse([
                                        'result' => false,
                                        'errors' => (string)$form->getErrors(true)
                                    ], 500);
        }

        return new JsonResponse($object);
    }

    /**
     * @param Request  $request
     * @param  integer $id
     * @return JsonResponse
     */
    public function putAction(Request $request, $id)
    {
        if (!$this->authorization->checkAuth($request)) {
            return new JsonResponse(['result' => false], 401);
        }

        $object = $this->getRepository()->find($id);

        if (null === $object) {
            return new JsonResponse(['result' => false], 405);
        }

        $form = $this->createForm($object);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isValid()) {
            $this->getEntityManager()->persist($object);
            $this->getEntityManager()->flush($object);
        } else {
            return new JsonResponse([
                                        'result' => false,
                                        'errors' => (string)$form->getErrors(true)
                                    ], 500);
        }

        return new JsonResponse($object);
    }

    /**
     * @param Request  $request
     * @param  integer $id
     * @return JsonResponse
     */
    public function patchAction(Request $request, $id)
    {
        if (!$this->authorization->checkAuth($request)) {
            return new JsonResponse(['result' => false], 401);
        }

        $object = $this->getRepository()->find($id);

        if (null === $object) {
            return new JsonResponse(['result' => false], 405);
        }

        $form = $this->createForm($object);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isValid()) {
            $this->getEntityManager()->persist($object);
            $this->getEntityManager()->flush($object);
        } else {
            return new JsonResponse([
                                        'result' => false,
                                        'errors' => (string)$form->getErrors(true)
                                    ], 500);
        }

        return new JsonResponse($object);
    }

    /**
     * @param Request $request
     * @param         $id
     * @return JsonResponse
     */
    public function deleteAction(Request $request, $id)
    {
        if (!$this->authorization->checkAuth($request)) {
            return new JsonResponse(['result' => false], 401);
        }

        $object = $this->getRepository()->find($id);

        if (null === $object) {
            return new JsonResponse(['result' => false], 405);
        }

        $this->getEntityManager()->remove($object);
        $this->getEntityManager()->flush($object);

        return new JsonResponse(['result' => true]);
    }
}