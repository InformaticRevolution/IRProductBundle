<?php

/*
 * This file is part of the IRProductBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ProductBundle\Manager;

/**
 * Abstract variant manager implementation.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
abstract class VariantManager implements VariantManagerInterface
{
    /**
     * {@inheritdoc}
     */  
    public function createVariant()
    {
        $class = $this->getClass();

        return new $class;
    } 
}
