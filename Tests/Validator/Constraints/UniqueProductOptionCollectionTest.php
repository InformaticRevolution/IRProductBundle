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
    
    /**
     * @expectedException \Symfony\Component\Validator\Exception\UnexpectedTypeException
     */
    public function testExpectsCollectionCompatibleType()
    {
        $this->validator->validate(new \stdClass(), new UniqueProductOptionCollection());
    }
   
    /**
     * @expectedException \Symfony\Component\Validator\Exception\UnexpectedTypeException
     */    
    public function testExpectsCollectionOfProductOptionInterfaceCompatibleType()
    {
        $collection = new ArrayCollection();
        $collection->add(new \stdClass());
        
        $this->validator->validate($collection, new UniqueProductOptionCollection());
    }    
  
    /**
     * @dataProvider getValidCollection
     */      
    public function testValidCollection($collection) 
    {        
        $this->context->expects($this->never())
            ->method('addViolation');        
        
        $this->validator->validate($collection, new UniqueProductOptionCollection());        
    }
    
    public function getValidCollection()
    {
        return array(
            array(
                new ArrayCollection(array(
                    $this->getProductOption(),
                    $this->getProductOption(),
                ))
            ),
            array(
                new ArrayCollection(array(
                    $this->getProductOption(),
                    $this->getProductOption(),
                    $this->getProductOption(),
                ))
            ),
        );
    }    
    
    /**
     * @dataProvider getInvalidCollection
     */        
    public function testInvalidCollection($collection) 
    {
        $this->context->expects($this->once())
            ->method('addViolation')
            ->with('myMessage');        
        
        $this->validator->validate($collection, new UniqueProductOptionCollection(array('message' => 'myMessage')));        
    }    

    public function getInvalidCollection()
    {
        $option = $this->getOption();
        
        return array(
            array(
                new ArrayCollection(array(
                    $this->getProductOption($option),
                    $this->getProductOption($option),
                ))
            ),
            array(
                new ArrayCollection(array(
                    $this->getProductOption($option),
                    $this->getProductOption(),
                    $this->getProductOption($option),
                ))
            ),
        );
    }       
    
    protected function getProductOption($option = null)
    {
        $productOption = $this->getMock('IR\Bundle\ProductBundle\Model\ProductOptionInterface');
     
        if (null === $option) {
            $option = $this->getOption();
        }
        
        $productOption->expects($this->any())
            ->method('getOption')
            ->will($this->returnValue($option));
        
        return $productOption;
    }   

    protected function getOption()
    {
        return $this->getMock('IR\Bundle\ProductBundle\Model\OptionInterface');
    }

    protected function tearDown()
    {
        $this->context = null;
        $this->validator = null;
    }        
}
