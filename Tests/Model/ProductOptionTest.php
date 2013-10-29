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
use IR\Bundle\ProductBundle\Model\ProductOptionInterface;

/**
 * Product Option Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class ProductOptionTest extends \PHPUnit_Framework_TestCase
{ 
    /**
     * @dataProvider getSimpleTestData
     */
    public function testSimpleSettersGetters($property, $value, $default)
    {
        $getter = 'get'.$property;
        $setter = 'set'.$property;
        
        $productOption = $this->getProductOption();
        
        $this->assertEquals($default, $productOption->$getter());
        $productOption->$setter($value);
        $this->assertEquals($value, $productOption->$getter());
    }
    
    public function getSimpleTestData()
    {
        return array(
            array('product', $this->getProduct(),null),
            array('option', $this->getOption(), null),
            array('position', 3, null),           
        );
    }      
    
    /**
     * @expectedException \BadMethodCallException
     */
    public function testGetNameThrowsExceptionUnlessOptionSet()
    {
        $productOption = $this->getProductOption();
        $productOption->getName();
    } 

    /**
     * @expectedException \BadMethodCallException
     */
    public function testGetPublicNameThrowsExceptionUnlessOptionSet()
    {
        $productOption = $this->getProductOption();
        $productOption->getPublicName();
    }     
    
    /**
     * @expectedException \BadMethodCallException
     */
    public function testGetValuesThrowsExceptionUnlessOptionSet()
    {
        $productOption = $this->getProductOption();
        $productOption->getValues();
    }      
    
    public function testGetName()
    {
        $option = $this->getOption();
        $option->setName('Color');
        $productOption = $this->getProductOption();
        $productOption->setOption($option);
        
        $this->assertSame('Color', $productOption->getName());
    }    
      
    public function testGetPublicName()
    {
        $option = $this->getOption();
        $option->setPublicName('Color');
        $productOption = $this->getProductOption();
        $productOption->setOption($option);
        
        $this->assertSame('Color', $productOption->getPublicName());
    }    
        
    public function testGetValues()
    {
        $productOption = $this->getProductOption();
        $productOption->setOption($this->getOption());
        
        $this->assertInstanceOf('Doctrine\Common\Collections\Collection', $productOption->getValues());
    }   
        
    /**
     * @return ProductOptionInterface
     */
    protected function getProductOption()
    {
        return $this->getMockForAbstractClass('IR\Bundle\ProductBundle\Model\ProductOption');
    }     
    
    /**
     * @return ProductInterface
     */
    protected function getProduct()
    {
        return $this->getMock('IR\Bundle\ProductBundle\Model\ProductInterface');
    }     
    
    /**
     * @return OptionInterface
     */
    protected function getOption()
    {
        return $this->getMockForAbstractClass('IR\Bundle\ProductBundle\Model\Option');
    }         
}
