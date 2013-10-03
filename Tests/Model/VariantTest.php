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

use IR\Bundle\ProductBundle\Model\Variant;
use IR\Bundle\ProductBundle\Model\OptionValue;

/**
 * Variant Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class VariantTest extends \PHPUnit_Framework_TestCase
{  
    public function testOptions()
    {
        $variant = new Variant();
        
        $this->assertEquals(new ArrayCollection(), $variant->getOptions());
    }
    
    public function testAddOption()
    {
        $variant = new Variant();
        $option = new OptionValue();
        
        $this->assertNotContains($option, $variant->getOptions());
        $variant->addOption($option);
        $this->assertContains($option, $variant->getOptions());
    }        
    
    public function testRemoveOption()
    {
        $variant = new Variant();
        $option = new OptionValue();
        $variant->addOption($option);
        
        $this->assertContains($option, $variant->getOptions());
        $variant->removeOption($option);
        $this->assertNotContains($option, $variant->getOptions());
    } 
    
    public function testHasOption()
    {
        $variant = new Variant();
        $option = new OptionValue();
        
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
        
        $variant = new Variant();
        
        $this->assertEquals($default, $variant->$getter());
        $variant->$setter($value);
        $this->assertEquals($value, $variant->$getter());
    }
    
    public function getSimpleTestData()
    {
        return array(
            array('createdAt', new \DateTime(), null),
            array('updatedAt', new \DateTime(), null),            
        );
    }   
}
