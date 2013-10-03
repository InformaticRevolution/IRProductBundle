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

use Doctrine\Common\Collections\ArrayCollection;
use IR\Bundle\ProductBundle\Model\Option;
use IR\Bundle\ProductBundle\Model\OptionValue;

/**
 * Option Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class OptionTest extends \PHPUnit_Framework_TestCase
{
    public function testValues()
    {
        $option = new Option();
        
        $this->assertEquals(new ArrayCollection(), $option->getValues());
    }
    
    public function testAddValue()
    {
        $option = new Option();
        $optionValue = new OptionValue();
        
        $this->assertNotContains($optionValue, $option->getValues());
        $option->addValue($optionValue);
        $this->assertContains($optionValue, $option->getValues());
    }
    
    public function testAddValueSetOption()
    {
        $option = new Option();
        $optionValue = new OptionValue();
        
        $this->assertNull($optionValue->getOption());
        $option->addValue($optionValue);
        $this->assertSame($option, $optionValue->getOption());
    }
            
    public function testRemoveValue()
    {
        $option = new Option();
        $optionValue = new OptionValue();
        $option->addValue($optionValue);
        
        $this->assertContains($optionValue, $option->getValues());
        $option->removeValue($optionValue);
        $this->assertNotContains($optionValue, $option->getValues());
    }       
    
    public function testHasValue()
    {
        $option = new Option();
        $optionValue = new OptionValue();
        
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
        
        $option = new Option();
        
        $this->assertEquals($default, $option->$getter());
        $option->$setter($value);
        $this->assertEquals($value, $option->$getter());
    }
    
    public function getSimpleTestData()
    {
        return array(
            array('Name', 'T-Shirt Color', null),
            array('PublicName', 'Color', null),
        );
    }    
    
    public function testToString()
    {
        $option = new Option();
        
        $this->assertEquals('', $option);
        $option->setPublicName('Color');
        $this->assertEquals('Color', $option);
    }
}
