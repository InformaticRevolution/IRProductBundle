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
use IR\Bundle\ProductBundle\Model\VariantInterface;
use IR\Bundle\ProductBundle\Model\OptionValueInterface;
use IR\Bundle\ProductBundle\Model\VariableProductInterface;

/**
 * Variant Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class VariantTest extends \PHPUnit_Framework_TestCase
{ 
    public function testConstructor()
    {
        $variant = $this->getVariant();
        
        $this->assertInstanceOf('Doctrine\Common\Collections\Collection', $variant->getOptions());
    }    
    
    public function testIsMasterVariant()
    {
        $variant = $this->getVariant();
        $product = $this->getProduct();
        
        $this->assertFalse($variant->isMasterVariant());
        $variant->setProduct($product);
        $this->assertFalse($variant->isMasterVariant());
        $product->setMasterVariant($variant);
        $this->assertTrue($variant->isMasterVariant());
    }
     
    public function testAddOption()
    {
        $variant = $this->getVariant();
        $optionValue = $this->getOptionValue();
        
        $this->assertNotContains($optionValue, $variant->getOptions());
        $variant->addOption($optionValue);
        $this->assertContains($optionValue, $variant->getOptions());
    }        
    
    public function testRemoveOption()
    {
        $variant = $this->getVariant();
        $optionValue = $this->getOptionValue();
        $variant->addOption($optionValue);
        
        $this->assertContains($optionValue, $variant->getOptions());
        $variant->removeOption($optionValue);
        $this->assertNotContains($optionValue, $variant->getOptions());
    } 
    
    public function testHasOption()
    {
        $variant = $this->getVariant();
        $optionValue = $this->getOptionValue();
        
        $this->assertFalse($variant->hasOption($optionValue));
        $variant->addOption($optionValue);
        $this->assertTrue($variant->hasOption($optionValue));
    }         
    
    public function testGetOption()
    {
        $variant = $this->getVariant();
        $option = $this->getOption();
        $optionValue = $this->getOptionValue();
        $optionValue->setOption($option);
        
        $this->assertNull($variant->getOption($option));        
        $variant->addOption($optionValue);        
        $this->assertSame($optionValue, $variant->getOption($option));
    }
           
    /**
     * @dataProvider getSimpleTestData
     */
    public function testSimpleSettersGetters($property, $value, $default)
    {
        $getter = 'get'.$property;
        $setter = 'set'.$property;
        
        $variant = $this->getVariant();
        
        $this->assertEquals($default, $variant->$getter());
        $variant->$setter($value);
        $this->assertEquals($value, $variant->$getter());
    }
    
    public function getSimpleTestData()
    {
        return array(
            array('product', $this->getProduct(), null),
            array('createdAt', new \DateTime(), null),
            array('updatedAt', new \DateTime(), null),            
        );
    }  
    
    /**
     * @return VariantInterface
     */
    protected function getVariant()
    {
        return $this->getMockForAbstractClass('IR\Bundle\ProductBundle\Model\Variant');
    } 
    
    /**
     * @return VariableProductInterface
     */
    protected function getProduct()
    {
        return $this->getMockForAbstractClass('IR\Bundle\ProductBundle\Model\VariableProduct');
    } 
    
    /**
     * @return OptionInterface
     */
    protected function getOption()
    {
        return $this->getMockForAbstractClass('IR\Bundle\ProductBundle\Model\Option');
    }     
    
    /**
     * @return OptionValueInterface
     */
    protected function getOptionValue()
    {
        return $this->getMockForAbstractClass('IR\Bundle\ProductBundle\Model\OptionValue');
    }      
}
