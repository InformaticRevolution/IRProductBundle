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

use IR\Bundle\ProductBundle\Manager\VariantManager;

/**
 * Variant Manager Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class VariantManagerTest extends \PHPUnit_Framework_TestCase
{
    const VARIANT_CLASS = 'IR\Bundle\ProductBundle\Model\Variant';
 
    /**
     * @var VariantManager
     */
    protected $variantManager;    
    
    
    public function setUp()
    {
        $this->variantManager = $this->getMockForAbstractClass('IR\Bundle\ProductBundle\Manager\VariantManager');
        
        $this->variantManager->expects($this->any())
            ->method('getClass')
            ->will($this->returnValue(self::VARIANT_CLASS));        
    }
    
    public function testCreateVariant()
    {        
        $variant = $this->variantManager->createVariant();
        
        $this->assertInstanceOf(self::VARIANT_CLASS, $variant);
    }
}