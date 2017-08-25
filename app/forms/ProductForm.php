<?php

namespace app\forms;

use app\models\Product;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ProductForm
 */
class ProductForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',
                  TextType::class,
                  [
                      'required'    => true,
                  ])
            ->add('price',
                  TextType::class,
                  [
                      'required'    => true,
                  ])
            ->add('category_id',
                  TextType::class,
                  [
                      'required'    => true,
                  ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
                                   'data_class' => Product::class,
                               ]);
    }
}