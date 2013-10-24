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
use Symfony\Component\Form\Extension\Core\ChoiceList\ObjectChoiceList;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Option Value Choice Type.
 * 
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class OptionValueChoiceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */       
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {   
        $choiceList = function (Options $options) {
            return new ObjectChoiceList($options['option']->getValues());
        };        
        
        $resolver
            ->setDefaults(array(
                'choice_list' => $choiceList
            ))
            ->setRequired(array(
                'option'
            ))
            ->addAllowedTypes(array(
                'option' => 'IR\Bundle\ProductBundle\Model\OptionInterface'
            ))
        ; 
    }    
    
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'choice';
    }    
    
    /**
     * {@inheritdoc}
     */        
    public function getName()
    {
        return 'ir_product_option_value_choice';
    }
}