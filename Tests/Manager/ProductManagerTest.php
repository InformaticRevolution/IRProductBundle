<?php

/*
 * This file is part of the IRProductBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ProductBundle\Tests\Manager;

use IR\Bundle\ProductBundle\Manager\ProductManager;

/**
 * Product Manager Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class ProductManagerTest extends \PHPUnit_Framework_TestCase
{
    const PRODUCT_CLASS = 'IR\Bundle\ProductBundle\Model\Product';
 
    /**
     * @var ProductManager
     */
    protected $productManager;    
    
    
    public function setUp()
    {
        $this->productManager = $this->getMockForAbstractClass('IR\Bundle\ProductBundle\Manager\ProductManager');
        
        $this->productManager->expects($this->any())
            ->method('getClass')
            ->will($this->returnValue(self::PRODUCT_CLASS));        
    }
    
    public function testCreateProduct()
    {        
        $product = $this->productManager->createProduct();
        
        $this->assertInstanceOf(self::PRODUCT_CLASS, $product);
    }
}