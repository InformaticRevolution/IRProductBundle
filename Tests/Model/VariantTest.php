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
    
    public function testAddOption()
    {
        $variant = $this->getVariant();
        $option = $this->getOptionValue();
        
        $this->assertNotContains($option, $variant->getOptions());
        $variant->addOption($option);
        $this->assertContains($option, $variant->getOptions());
    }        
    
    public function testRemoveOption()
    {
        $variant = $this->getVariant();
        $option = $this->getOptionValue();
        $variant->addOption($option);
        
        $this->assertContains($option, $variant->getOptions());
        $variant->removeOption($option);
        $this->assertNotContains($option, $variant->getOptions());
    } 
    
    public function testHasOption()
    {
        $variant = $this->getVariant();
        $option = $this->getOptionValue();
        
        $this->assertFalse($variant->hasOption($option));
        $variant->addOption($option);
        $this->assertTrue($variant->hasOption($option));
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
        return $this->getMock('IR\Bundle\ProductBundle\Model\VariableProductInterface');
    }  
    
    /**
     * @return OptionValueInterface
     */
    protected function getOptionValue()
    {
        return $this->getMock('IR\Bundle\ProductBundle\Model\OptionValueInterface');
    }      
}
