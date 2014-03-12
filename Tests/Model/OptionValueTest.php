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
 * Option Value Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class OptionValueTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getSimpleTestData
     */
    public function testSimpleSettersGetters($property, $value, $default)
    {
        $getter = 'get'.$property;
        $setter = 'set'.$property;
        
        $optionValue = $this->getOptionValue();
        
        $this->assertEquals($default, $optionValue->$getter());
        $optionValue->$setter($value);
        $this->assertEquals($value, $optionValue->$getter());
    }
    
    public function getSimpleTestData()
    {
        return array(
            array('option', $this->getOption(), null),
            array('value', 'Black', null),
            array('position', 2, null),
        );
    } 

    public function testToString()
    {
        $optionValue = $this->getOptionValue();
        
        $this->assertEquals('', $optionValue);
        $optionValue->setValue('Black');
        $this->assertEquals('Black', $optionValue);
    }
        
    /**
     * @return OptionValueInterface
     */
    protected function getOptionValue()
    {
        return $this->getMockForAbstractClass('IR\Bundle\ProductBundle\Model\OptionValue');
    }
    
    /**
     * @return OptionInterface
     */
    protected function getOption()
    {
        return $this->getMockForAbstractClass('IR\Bundle\ProductBundle\Model\OptionInterface');
    }      
}
