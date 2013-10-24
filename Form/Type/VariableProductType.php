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

use Symfony\Component\Form\FormBuilderInterface;
use IR\Bundle\ProductBundle\Form\EventListener\BuildVariableProductFormListener;

/**
 * Variable Product Type.
 * 
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class VariableProductType extends ProductType
{
    /**
     * {@inheritdoc}
     */     
    public function buildForm(FormBuilderInterface $builder, array $options)
    {   
        parent::buildForm($builder, $options);
        
        $builder
            ->add('masterVariant', 'ir_product_variant', array(
                'master' => true,
                'label' => 'form.product.master_variant',
                'translation_domain' => 'ir_product',                
            ))        
            ->addEventSubscriber(new BuildVariableProductFormListener());
        ;
    }
}