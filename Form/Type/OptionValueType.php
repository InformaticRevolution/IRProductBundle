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
 * Option Value Type.
 * 
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class OptionValueType extends AbstractType
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
        $builder
            ->add('value', null, array(                 
                'label' => 'form.option_value.value',
                'translation_domain' => 'ir_product',
            ))         
        ;
    }

    /**
     * {@inheritdoc}
     */       
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->class,
            'intention' => 'option_value',   
        ));        
    }    
    
    /**
     * {@inheritdoc}
     */        
    public function getName()
    {
        return 'ir_product_option_value';
    }
}