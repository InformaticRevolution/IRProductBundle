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
use IR\Bundle\ProductBundle\Model\OptionValueInterface;

/**
 * Option Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class OptionTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $option = $this->getOption();
        
        $this->assertInstanceOf('Doctrine\Common\Collections\Collection', $option->getValues());
    }    

    public function testAddValue()
    {
        $option = $this->getOption();
        $optionValue = $this->getOptionValue();
        
        $this->assertNotContains($optionValue, $option->getValues());
        $this->assertNull($optionValue->getOption());
        
        $option->addValue($optionValue);
        
        $this->assertContains($optionValue, $option->getValues());
        $this->assertSame($option, $optionValue->getOption());
    }
    
    public function testRemoveValue()
    {
        $option = $this->getOption();
        $optionValue = $this->getOptionValue();
        $option->addValue($optionValue);
        
        $this->assertContains($optionValue, $option->getValues());
        $this->assertSame($option, $optionValue->getOption());
        
        $option->removeValue($optionValue);
        
        $this->assertNotContains($optionValue, $option->getValues());
        $this->assertNull($optionValue->getOption());
    }       

    public function testHasValue()
    {
        $option = $this->getOption();
        $optionValue = $this->getOptionValue();
        
        $this->assertFalse($option->hasValue($optionValue));
        $option->addValue($optionValue);
        $this->assertTrue($option->hasValue($optionValue));
    }
       
    /**
     * @dataProvider getSimpleTestData
     */
    public function testSimpleSettersGetters($property, $value, $default)
    {
        $getter = 'get'.$property;
        $setter = 'set'.$property;
        
        $option = $this->getOption();
        
        $this->assertEquals($default, $option->$getter());
        $option->$setter($value);
        $this->assertEquals($value, $option->$getter());
    }
    
    public function getSimpleTestData()
    {
        return array(
            array('name', 'T-Shirt Color', null),
            array('publicName', 'Color', null),
            array('createdAt', new \DateTime(), null),
            array('updatedAt', new \DateTime(), null),
        );
    }    
    
    public function testToString()
    {
        $option = $this->getOption();
        
        $this->assertEquals('', $option);
        $option->setPublicName('Color');
        $this->assertEquals('Color', $option);
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
