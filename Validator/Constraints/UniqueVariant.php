<?php

/*
 * This file is part of the IRProductBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ProductBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Unique Variant Constraint.
 * 
 * @Annotation
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class UniqueVariant extends Constraint
{
    public $message = 'This variant is already used';

    
    /**
     * {@inheritdoc}
     */       
    public function validatedBy()
    {
        return 'ir_product_unique_variant';
    } 
    
    /**
     * {@inheritDoc}
     */
    public function getTargets()
    {
        return static::CLASS_CONSTRAINT;
    }    
}