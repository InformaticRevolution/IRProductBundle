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

use IR\Bundle\ProductBundle\Model\Option;
use IR\Bundle\ProductBundle\Model\OptionValue;

/**
 * Option Value Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class OptionValueTest extends \PHPUnit_Framework_TestCase
{
    public function testOption()
    {
        $optionValue = new OptionValue();
        $option = new Option();
        
        $this->assertNull($optionValue->getOption());
        $optionValue->setOption($option);
        $this->assertSame($option, $optionValue->getOption());
    }
    
    public function testValue()
    {
        $optionValue = new OptionValue();
        
        $this->assertNull($optionValue->getValue());
        $optionValue->setValue('Black');
        $this->assertEquals('Black', $optionValue->getValue());
    }

    public function testToString()
    {
        $optionValue = new OptionValue();
        
        $this->assertEquals('', $optionValue);
        $optionValue->setValue('Black');
        $this->assertEquals('Black', $optionValue);
    }
}
