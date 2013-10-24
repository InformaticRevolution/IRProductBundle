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

use IR\Bundle\ProductBundle\Model\VariableProduct;
use IR\Bundle\ProductBundle\Model\Variant;

/**
 * Variable Product Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class VariableProductTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $product = $this->getProduct();
        
        $this->assertInstanceOf('Doctrine\Common\Collections\Collection', $product->getVariants());
    }  
        
    public function testMasterVariant()
    {
        $product = $this->getProduct();
        $variant = $this->getVariant();
                
        $this->assertNull($product->getMasterVariant());
        $this->assertNull($variant->getProduct());
        
        $product->setMasterVariant($variant);
        
        $this->assertSame($variant, $product->getMasterVariant());
        $this->assertSame($product, $variant->getProduct());
    }

    public function testAddVariant()
    {
        $product = $this->getProduct();
        $variant = $this->getVariant();
        
        $this->assertNotContains($variant, $product->getVariants());
        $this->assertNull($variant->getProduct());
        
        $product->addVariant($variant);
        
        $this->assertContains($variant, $product->getVariants());
        $this->assertSame($product, $variant->getProduct());
    }
    
    public function testRemoveVariant()
    {
        $product = $this->getProduct();
        $variant = $this->getVariant();
        $product->addVariant($variant);
        
        $this->assertContains($variant, $product->getVariants());
        $this->assertSame($product, $variant->getProduct());
        
        $product->removeVariant($variant);
        
        $this->assertNotContains($variant, $product->getVariants());
        $this->assertNull($variant->getProduct());
    }        
    
    public function testHasVariant()
    {
        $product = $this->getProduct();
        $variant = $this->getVariant();
        
        $this->assertFalse($product->hasVariant($variant));
        $product->addVariant($variant);
        $this->assertTrue($product->hasVariant($variant));
    }
    
    /**
     * @return VariableProduct
     */
    protected function getProduct()
    {
        return $this->getMockForAbstractClass('IR\Bundle\ProductBundle\Model\VariableProduct');
    }      
    
    /**
     * @return Variant
     */
    protected function getVariant()
    {
        return $this->getMockForAbstractClass('IR\Bundle\ProductBundle\Model\Variant');
    }      
}
