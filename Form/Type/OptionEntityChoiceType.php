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
 * Option entity choice type.
 * 
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class OptionEntityChoiceType extends OptionChoiceType
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'entity';
    }
}