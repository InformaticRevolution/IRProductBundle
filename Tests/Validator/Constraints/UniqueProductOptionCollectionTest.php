<?php

/*
 * This file is part of the IRProductBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ProductBundle\Tests\Validator\Constraints;

use Doctrine\Common\Collections\ArrayCollection;
use IR\Bundle\ProductBundle\Model\ProductOptionInterface;
use IR\Bundle\ProductBundle\Validator\Constraints\UniqueProductOptionCollection;
use IR\Bundle\ProductBundle\Validator\Constraints\UniqueProductOptionCollectionValidator;

/**
 * Unique Product Option Collection Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class UniqueProductOptionCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $context;
    
    /**
     * @var UniqueProductOptionCollectionValidator 
     */
    protected $validator;
    
    
    protected function setUp()
    {
        $this->context = $this->getMock('Symfony\Component\Validator\ExecutionContext', array(), array(), '', false);
        $this->validator = new UniqueProductOptionCollectionValidator();
        $this->validator->initialize($this->context);
    }
    
    protected function tearDown()
    {
        $this->context = null;
        $this->validator = null;
    }    
    
    /**
     * @expectedException \Symfony\Component\Validator\Exception\UnexpectedTypeException
     */
    public function testValidateThrowsExceptionUnlessCollectionGiven()
    {
        $this->validator->validate(new \stdClass(), new UniqueProductOptionCollection());
    }
   
    /**
     * @expectedException \Symfony\Component\Validator\Exception\ValidatorException
     */    
    public function testValidateThrowsExceptionUnlessCollectionObjectOfTypeProductOption()
    {
        $collection = new ArrayCollection();
        $collection->add(new \stdClass());
        
        $this->validator->validate($collection, new UniqueProductOptionCollection());
    }    
  
    public function testValidCollection() 
    {
        $productOption1 = $this->getProductOption('T-Shirt Size', 'Size');
        $productOption2 = $this->getProductOption('T-Shirt Color', 'Color');
        $productOption3 = $this->getProductOption('T-Shirt Color', 'Color');
        $collection = new ArrayCollection(array($productOption1, $productOption2, $productOption3));
        
        $this->context->expects($this->never())
            ->method('addViolation');        
        
        $this->validator->validate($collection, new UniqueProductOptionCollection());        
    }
    
    public function testInvalidCollection() 
    {
        $productOption1 = $this->getProductOption('T-Shirt Size', 'Size');
        $productOption2 = $this->getProductOption('T-Shirt Color', 'Color');
        $collection = new ArrayCollection(array($productOption1, $productOption2, $productOption1));

        $this->context->expects($this->once())
            ->method('addViolation')
            ->with('myMessage');        
        
        $this->validator->validate($collection, new UniqueProductOptionCollection(array('message' => 'myMessage')));        
    }    
    
    /**
     * @return ProductOptionInterface
     */
    protected function getProductOption($name, $publicName)
    {
        $option = $this->getMockForAbstractClass('IR\Bundle\ProductBundle\Model\Option');
        $productOption = $this->getMockForAbstractClass('IR\Bundle\ProductBundle\Model\ProductOption');
        
        $option->setName($name);
        $option->setPublicName($publicName);
        $productOption->setOption($option);
        
        return $productOption;
    }   
}
