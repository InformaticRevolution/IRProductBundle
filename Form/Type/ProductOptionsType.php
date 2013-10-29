<?php

/*
 * This file is part of the IRProductBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ProductBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Product Options Type.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class ProductOptionsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {           
        foreach ($options['product']->getOptions() as $i => $option) {
            $builder->add($i, 'ir_product_option_value_choice', array(
                'option' => $option->getOption(),
                'label' => $option->getName().' :',
            ));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setRequired(array(
                'product'
            ))
            ->addAllowedTypes(array(
                'product' => 'IR\Bundle\ProductBundle\Model\ProductInterface'
            ))
        ; 
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'ir_product_product_options';
    }
}