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

use IR\Bundle\ProductBundle\Model\OptionInterface;
use IR\Bundle\ProductBundle\Model\ProductInterface;

/**
 * Product Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class ProductTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $product = $this->getProduct();
        
        $this->assertInstanceOf('Doctrine\Common\Collections\Collection', $product->getOptions());
    }  
    
    public function testHasOptions()
    {
        $product = $this->getProduct();
        $option = $this->getOption();
        
        $this->assertFalse($product->hasOptions());
        $product->addOption($option);
        $this->assertTrue($product->hasOptions());
    }
    
    public function testAddOption()
    {
        $product = $this->getProduct();
        $option = $this->getOption();
        
        $this->assertNotContains($option, $product->getOptions());
        $product->addOption($option);
        $this->assertContains($option, $product->getOptions());
    }
    
    public function testRemoveOption()
    {
        $product = $this->getProduct();
        $option = $this->getOption();
        $product->addOption($option);
        
        $this->assertContains($option, $product->getOptions());
        $product->removeOption($option);
        $this->assertNotContains($option, $product->getOptions());      
    }       
    
    public function testHasOption()
    {
        $product = $this->getProduct();
        $option = $this->getOption();
        
        $this->assertFalse($product->hasOption($option));
        $product->addOption($option);
        $this->assertTrue($product->hasOption($option));
    }        
   
    /**
     * @dataProvider getSimpleTestData
     */
    public function testSimpleSettersGetters($property, $value, $default)
    {
        $getter = 'get'.$property;
        $setter = 'set'.$property;
        
        $product = $this->getProduct();
        
        $this->assertEquals($default, $product->$getter());
        $product->$setter($value);
        $this->assertEquals($value, $product->$getter());
    }
    
    public function getSimpleTestData()
    {
        return array(
            array('name', 'Product 1', null),
            array('slug', 'product-1', null),
            array('description', 'Some product description...', null),
            array('createdAt', new \DateTime(), null),
            array('updatedAt', new \DateTime(), null),            
        );
    }     
    
    public function testToString()
    {
        $product = $this->getProduct();
        
        $this->assertEquals('', $product);
        $product->setName('Product 1');
        $this->assertEquals('Product 1', $product);
    }
    
    /**
     * @return ProductInterface
     */
    protected function getProduct()
    {
        return $this->getMockForAbstractClass('IR\Bundle\ProductBundle\Model\Product');
    }      
    
    /**
     * @return OptionInterface
     */
    protected function getOption()
    {
        return $this->getMock('IR\Bundle\ProductBundle\Model\OptionInterface');
    }      
}
