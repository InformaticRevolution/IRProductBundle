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
 * Variant Options Type.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class VariantOptionsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {   
        $product = $options['variant']->getProduct();
        
        if (null === $product) {
            return;
        }
        
        foreach ($product->getOptions() as $i => $option) {
            $option = $option->getOption();
            
            $builder->add($i, 'ir_product_option_value_choice', array(
                'option' => $option,
                'label' => $option->getName().' :',
                'data' => $options['variant']->getOption($option),
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
                'variant'
            ))
            ->addAllowedTypes(array(
                'variant' => 'IR\Bundle\ProductBundle\Model\VariantInterface'
            ))
        ; 
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'ir_product_variant_options';
    }
}