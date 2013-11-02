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
 * Unique Product Option Collection.
 * 
 * @Annotation
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class UniqueProductOptionCollection extends Constraint
{
    public $message = 'The collection of options must be unique';  
}