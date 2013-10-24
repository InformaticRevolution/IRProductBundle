<?php

/*
 * This file is part of the IRProductBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ProductBundle\Tests\Manager;

use IR\Bundle\ProductBundle\Manager\OptionManager;

/**
 * Option Manager Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class OptionManagerTest extends \PHPUnit_Framework_TestCase
{
    const OPTION_CLASS = 'IR\Bundle\ProductBundle\Tests\TestOption';
 
    /**
     * @var OptionManager
     */
    protected $optionManager;    
    
    
    public function setUp()
    {
        $this->optionManager = $this->getMockForAbstractClass('IR\Bundle\ProductBundle\Manager\OptionManager');
        
        $this->optionManager->expects($this->any())
            ->method('getClass')
            ->will($this->returnValue(static::OPTION_CLASS));        
    }
    
    public function testCreateOption()
    {        
        $option = $this->optionManager->createOption();
        
        $this->assertInstanceOf(static::OPTION_CLASS, $option);
    }
}