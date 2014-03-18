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

use IR\Bundle\ProductBundle\Doctrine\ProductManager;

/**
 * Product Manager Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class ProductManagerTest extends \PHPUnit_Framework_TestCase
{
    const PRODUCT_CLASS = 'IR\Bundle\ProductBundle\Tests\TestProduct';
    
    /**
     * @var ProductManager
     */
    protected $productManager;

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
            ->with($this->equalTo(static::PRODUCT_CLASS))
            ->will($this->returnValue($this->repository));        

        $this->objectManager->expects($this->any())
            ->method('getClassMetadata')
            ->with($this->equalTo(static::PRODUCT_CLASS))
            ->will($this->returnValue($class));        
        
        $class->expects($this->any())
            ->method('getName')
            ->will($this->returnValue(static::PRODUCT_CLASS));        
        
        $this->productManager = new ProductManager($this->objectManager, static::PRODUCT_CLASS);
    }    

    public function testUpdateProduct()
    {
        $product = $this->getProduct();
        
        $this->objectManager->expects($this->once())
            ->method('persist')
            ->with($this->equalTo($product));
        
        $this->objectManager->expects($this->once())
            ->method('flush');

        $this->productManager->updateProduct($product);
    }
    
    public function testDeleteProduct()
    {
        $product = $this->getProduct();
        
        $this->objectManager->expects($this->once())
            ->method('remove')
            ->with($this->equalTo($product));
        
        $this->objectManager->expects($this->once())
            ->method('flush');

        $this->productManager->deleteProduct($product);
    }      
    
    public function testFindProductBy()
    {
        $criteria = array("foo" => "bar");
        
        $this->repository->expects($this->once())
            ->method('findOneBy')
            ->with($this->equalTo($criteria))
            ->will($this->returnValue(array()));

        $this->productManager->findProductBy($criteria);
    }

    public function testFindArticlesBy()
    {
        $criteria = array("foo" => "bar");
        $orderBy = array("foo" => "asc");
        $limit = 3;
        $offset = 0;
        
        $this->repository->expects($this->once())
            ->method('findBy')
            ->with(
                $this->equalTo($criteria), 
                $this->equalTo($orderBy), 
                $this->equalTo($limit), 
                $this->equalTo($offset)
            )
            ->will($this->returnValue(array()));

        $this->productManager->findProductsBy($criteria, $orderBy, $limit, $offset);
    }     
    
    public function testGetClass()
    {
        $this->assertEquals(static::PRODUCT_CLASS, $this->productManager->getClass());
    }

    protected function getProduct()
    {
        $class = static::PRODUCT_CLASS;

        return new $class();
    }    
}
