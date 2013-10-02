<?php

/*
 * This file is part of the IRProductBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ProductBundle\Tests\Model;

use IR\Bundle\ProductBundle\Model\Product;

/**
 * Product Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class ProductTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getSimpleTestData
     */
    public function testSimpleSettersGetters($property, $value, $default)
    {
        $getter = 'get'.$property;
        $setter = 'set'.$property;
        
        $product = new Product;
        
        $this->assertEquals($default, $product->$getter());
        $product->$setter($value);
        $this->assertEquals($value, $product->$getter());
    }
    
    public function getSimpleTestData()
    {
        return array(
            array('Name', 'Product 1', null),
            array('Slug', 'product-1', null),
            array('Description', 'Some product description...', null),
        );
    }     
    
    public function testToString()
    {
        $product = new Product;
        
        $this->assertEquals('', $product);
        $product->setName('Product 1');
        $this->assertEquals('Product 1', $product);
    }        
}
