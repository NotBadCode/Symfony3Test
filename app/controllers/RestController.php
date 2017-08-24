<?php

namespace app\controllers;

use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\Form\FormFactoryInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\ORM\EntityManager;

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

    /**
     * @param FormFactoryInterface $formFactory
     * @param EntityManager        $entityManager
     */
    public function __construct(FormFactoryInterface $formFactory, EntityManager $entityManager)
    {
        $this->formFactory   = $formFactory;
        $this->entityManager = $entityManager;
    }

    /**
     * @param null  $data
     * @param array $options
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createForm($data = null, $options = [])
    {
        return $this->formFactory->create(new $this->formType(), $data, $options);
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
     * @return array
     */
    public function listAction(Request $request)
    {
        $offset = $request->headers->get('offset', 0);
        $limit  = $request->headers->get('limit', 10);

        return $this->getRepository()->findBy(
            [],
            null,
            $limit,
            $offset
        );
    }

    /**
     * @param int $id
     *
     * @return object
     *
     * @View(serializerGroups={"show"}, serializerEnableMaxDepthChecks=true)
     */
    public function getAction($id)
    {
        $object = $this->getRepository()->find($id);

        if (!$object) {
            throw new NotFoundHttpException(sprintf('%s#%s not found', $this->entityClass, $id));
        }

        return $object;
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     *
     * @View()
     */
    public function postAction(Request $request)
    {
        $object = new $this->entityClass();

        $form = $this->createForm($object);
        $form->submit($request);

        if ($form->isValid()) {
            $this->getEntityManager()->persist($object);
            $this->getEntityManager()->flush($object);

            return $object;
        }

        return $form;
    }

    /**
     * @param Request $request
     * @param integer $id
     *
     * @return null|object|\Symfony\Component\Form\FormInterface
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

            return $object;
        }

        return $form;
    }

    /**
     * @param Request $request
     * @param         $id
     *
     * @View()
     *
     * @return object|\Symfony\Component\Form\FormInterface
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

            return $object;
        }

        return $form;
    }

    /**
     * @param int $id
     *
     * @return array
     *
     * @View()
     */
    public function deleteAction($id)
    {

        $object = $this->getRepository()->find($id);

        if (!$object) {
            throw new NotFoundHttpException(sprintf('%s#%s not found', $this->entityClass, $id));
        }

        $this->getEntityManager()->remove($object);
        $this->getEntityManager()->flush($object);

        return ['success' => true];
    }

}