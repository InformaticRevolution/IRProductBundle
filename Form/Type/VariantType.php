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
use IR\Bundle\ProductBundle\Form\EventListener\BuildVariantFormListener;

/**
 * Variant type.
 * 
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class VariantType extends AbstractType
{
    /**
     * @var string
     */         
    protected $class;

    
    /**
     * Constructor.
     * 
     * @param string $class
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    /**
     * {@inheritdoc}
     */     
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (!$options['master']) {
            $builder->addEventSubscriber(new BuildVariantFormListener());
        }        
    }

    /**
     * {@inheritdoc}
     */       
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->class,
            'intention' => 'variant', 
            'master' => false,
        ));        
    }    
    
    /**
     * {@inheritdoc}
     */        
    public function getName()
    {
        return 'ir_product_variant';
    }
}