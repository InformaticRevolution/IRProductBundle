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
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Option Choice Type.
 * 
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
abstract class OptionChoiceType extends AbstractType
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
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'class' => $this->class,
        ));        
    }    
    
    /**
     * {@inheritdoc}
     */        
    public function getName()
    {
        return 'ir_product_option_choice';
    }
}