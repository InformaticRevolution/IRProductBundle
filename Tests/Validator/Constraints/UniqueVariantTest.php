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
use IR\Bundle\ProductBundle\Validator\Constraints\UniqueVariant;
use IR\Bundle\ProductBundle\Validator\Constraints\UniqueVariantValidator;

/**
 * Unique Variant Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class UniqueVariantTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $context;
    
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $variantManager;    
    
    /**
     * @var UniqueVariantValidator 
     */
    protected $validator;
    
    
    protected function setUp()
    {
        $this->context = $this->getMock('Symfony\Component\Validator\ExecutionContext', array(), array(), '', false);
        $this->variantManager = $this->getMock('IR\Bundle\ProductBundle\Manager\VariantManagerInterface');
        
        $this->validator = new UniqueVariantValidator($this->variantManager);
        $this->validator->initialize($this->context);
    }
    
    /**
     * @expectedException \Symfony\Component\Validator\Exception\UnexpectedTypeException
     */
    public function testExpectsVariantInterfaceCompatibleType()
    {
        $this->validator->validate(new \stdClass(), new UniqueVariant());
    }
   
    /**
     * @dataProvider getValidVariants
     */    
    public function testValidVariant($variant, $variants)
    {     
        $this->variantManager->expects($this->any())
            ->method('findVariantsByProductWithOptions')
            ->will($this->returnValue($variants));
        
        $this->context->expects($this->never())
            ->method('addViolationAt');        
        
        $this->validator->validate($variant, new UniqueVariant());        
    }
    
    public function getValidVariants()
    {
        return array(
            array(
                $this->getVariant(array($this->getOptionValue())),
                array(
                    $this->getVariant(array($this->getOptionValue())),
                    $this->getVariant(array($this->getOptionValue())),
                    $this->getVariant(array($this->getOptionValue())),
                )
            ),
            array(
                $this->getVariant(array($this->getOptionValue(), $this->getOptionValue())),
                array(
                    $this->getVariant(array($this->getOptionValue(), $this->getOptionValue())),
                    $this->getVariant(array($this->getOptionValue(), $this->getOptionValue())),
                    $this->getVariant(array($this->getOptionValue(), $this->getOptionValue())),
                )
            ),
        );
    }    
    
    /**
     * @dataProvider getInvalidVariants
     */        
    public function testInvalidVariant($variant, $variants)
    {
        $this->variantManager->expects($this->any())
            ->method('findVariantsByProductWithOptions')
            ->will($this->returnValue($variants));    
        
        $this->context->expects($this->atLeastOnce())
            ->method('addViolationAt')
            ->with($this->matchesRegularExpression('/^options\[\d\]$/'), $this->equalTo('myMessage'));        
        
        $this->validator->validate($variant, new UniqueVariant(array('message' => 'myMessage')));          
    }
    
    public function getInvalidVariants()
    {
        $optionValue1 = $this->getOptionValue();
        $optionValue2 = $this->getOptionValue();
        
        return array(
            array(
                $this->getVariant(array($optionValue1)),
                array(
                    $this->getVariant(array($this->getOptionValue())),
                    $this->getVariant(array($this->getOptionValue())),
                    $this->getVariant(array($optionValue1)),
                )
            ),
            array(
                $this->getVariant(array($optionValue1, $optionValue2)),
                array(
                    $this->getVariant(array($this->getOptionValue(), $this->getOptionValue())),
                    $this->getVariant(array($optionValue1, $optionValue2)),
                    $this->getVariant(array($this->getOptionValue(), $this->getOptionValue())),
                )
            ),
        );
    }      
    
    public function getVariant(array $options)
    {
        $variant = $this->getMock('IR\Bundle\ProductBundle\Model\VariantInterface');
        $product = $this->getMock('IR\Bundle\ProductBundle\Model\VariableProductInterface');

        $variant->expects($this->any())
            ->method('getProduct')
            ->will($this->returnValue($product));
        
        $variant->expects($this->any())
            ->method('getOptions')
            ->will($this->returnValue(new ArrayCollection($options)));
        
        return $variant;
    }
    
    public function getOptionValue()
    {
        return $this->getMock('IR\Bundle\ProductBundle\Model\OptionValueInterface');
    }
            
    protected function tearDown()
    {
        $this->context = null;
        $this->validator = null;
    }        
}
