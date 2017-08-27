<?php

namespace app\forms;

use app\models\Category;
use app\models\Product;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ProductForm
 */
class ProductForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',
                  TextType::class,
                  [
                      'required' => true,
                  ])
            ->add('price',
                  TextType::class,
                  [
                      'required' => true,
                  ])
            ->add('categories',
                  CollectionType::class,
                  [
                      'entry_type'   => CategoryForm::class,
                      'allow_add'    => true,
                      'allow_delete' => true,
                      'prototype'    => true,
                      'by_reference' => false,
                  ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
                                   'data_class' => Product::class,
                               ]);
    }
}