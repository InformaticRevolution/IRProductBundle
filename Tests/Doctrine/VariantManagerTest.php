<?php

/*
 * This file is part of the IRProductBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ProductBundle\Tests\Doctrine;

use IR\Bundle\ProductBundle\Doctrine\VariantManager;

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

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $objectManager;
    
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $repository;
    
    
    public function setUp()
    {
        if (!interface_exists('Doctrine\Common\Persistence\ObjectManager')) {
            $this->markTestSkipped('Doctrine Common has to be installed for this test to run.');
        }  
                
        $class = $this->getMock('Doctrine\Common\Persistence\Mapping\ClassMetadata');
        $this->objectManager = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $this->repository = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');
                
        $this->objectManager->expects($this->any())
            ->method('getRepository')
            ->with($this->equalTo(self::VARIANT_CLASS))
            ->will($this->returnValue($this->repository));        

        $this->objectManager->expects($this->any())
            ->method('getClassMetadata')
            ->with($this->equalTo(self::VARIANT_CLASS))
            ->will($this->returnValue($class));        
        
        $class->expects($this->any())
            ->method('getName')
            ->will($this->returnValue(self::VARIANT_CLASS));        
        
        $this->variantManager = new VariantManager($this->objectManager, self::VARIANT_CLASS);
    }    
   
    public function testGetClass()
    {
        $this->assertEquals(self::VARIANT_CLASS, $this->variantManager->getClass());
    }   
}
