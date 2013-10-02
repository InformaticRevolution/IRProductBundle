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
 * Abstract Product Manager.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
abstract class ProductManager implements ProductManagerInterface
{
    /**
     * {@inheritdoc}
     */  
    public function createProduct()
    {
        $class = $this->getClass();

        return new $class;
    } 
}
