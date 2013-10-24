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

use IR\Bundle\ProductBundle\Doctrine\OptionManager;

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
            ->with($this->equalTo(static::OPTION_CLASS))
            ->will($this->returnValue($this->repository));        

        $this->objectManager->expects($this->any())
            ->method('getClassMetadata')
            ->with($this->equalTo(static::OPTION_CLASS))
            ->will($this->returnValue($class));        
        
        $class->expects($this->any())
            ->method('getName')
            ->will($this->returnValue(static::OPTION_CLASS));        
        
        $this->optionManager = new OptionManager($this->objectManager, static::OPTION_CLASS);
    }    

    public function testUpdateOption()
    {
        $option = $this->getOption();
        
        $this->objectManager->expects($this->once())
            ->method('persist')
            ->with($this->equalTo($option));
        
        $this->objectManager->expects($this->once())
            ->method('flush');

        $this->optionManager->updateOption($option);
    }
    
    public function testDeleteOption()
    {
        $option = $this->getOption();
        
        $this->objectManager->expects($this->once())
            ->method('remove')
            ->with($this->equalTo($option));
        
        $this->objectManager->expects($this->once())
            ->method('flush');

        $this->optionManager->deleteOption($option);
    }      
    
    public function testFindOptionBy()
    {
        $criteria = array("foo" => "bar");
        
        $this->repository->expects($this->once())
            ->method('findOneBy')
            ->with($this->equalTo($criteria))
            ->will($this->returnValue(array()));

        $this->optionManager->findOptionBy($criteria);
    }
    
    public function testFindOptions()
    {
        $this->repository->expects($this->once())
            ->method('findAll')
            ->will($this->returnValue(array())); 
        
        $this->optionManager->findOptions();
    }
            
    public function testGetClass()
    {
        $this->assertEquals(static::OPTION_CLASS, $this->optionManager->getClass());
    }
    
    protected function getOption()
    {
        $class = static::OPTION_CLASS;

        return new $class();
    }  
}
