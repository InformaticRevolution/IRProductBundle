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
 * Option Type.
 * 
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class OptionType extends AbstractType
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
            ->add('name', null, array(                 
                'label' => 'form.option.name',
                'translation_domain' => 'ir_product',
            )) 
            ->add('publicName', null, array(                 
                'label' => 'form.option.public_name',
                'translation_domain' => 'ir_product',
            ))
            ->add('values', 'collection', array(
                'type' => 'ir_product_option_value',
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => 'form.option.values',
                'translation_domain' => 'ir_product',
            ));
    }

    /**
     * {@inheritdoc}
     */       
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->class,
            'intention' => 'option',   
        ));        
    }    
    
    /**
     * {@inheritdoc}
     */        
    public function getName()
    {
        return 'ir_product_option';
    }
}