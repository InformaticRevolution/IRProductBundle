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

use IR\Bundle\ProductBundle\Model\Product;
use IR\Bundle\ProductBundle\Model\Option;
use IR\Bundle\ProductBundle\Model\Variant;

/**
 * Product Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class ProductTest extends \PHPUnit_Framework_TestCase
{
    public function testHasOptions()
    {
        $product = new Product();
        $option = new Option();
        
        $this->assertFalse($product->hasOptions());
        $product->addOption($option);
        $this->assertTrue($product->hasOptions());
    }
            
    public function testGetOptions()
    {
        $product = new Product();
        
        $this->assertEquals(new ArrayCollection(), $product->getOptions());
    }
    
    public function testAddOption()
    {
        $product = new Product();
        $option = new Option();
        
        $this->assertNotContains($option, $product->getOptions());
        $product->addOption($option);
        $this->assertContains($option, $product->getOptions());
    }
    
    public function testRemoveOption()
    {
        $product = new Product();
        $option = new Option();
        $product->addOption($option);
        
        $this->assertContains($option, $product->getOptions());
        $product->removeOption($option);
        $this->assertNotContains($option, $product->getOptions());      
    }       
    
    public function testHasOption()
    {
        $product = new Product();
        $option = new Option();
        
        $this->assertFalse($product->hasOption($option));
        $product->addOption($option);
        $this->assertTrue($product->hasOption($option));
    }        
    
    public function testMasterVariant()
    {
        $product = new Product();
        $variant = new Variant();
        
        $this->assertNull($product->getMasterVariant());
        $this->assertNull($variant->getProduct());
        $this->assertFalse($variant->isMaster());
        
        $product->setMasterVariant($variant);
        
        $this->assertSame($variant, $product->getMasterVariant());
        $this->assertSame($product, $variant->getProduct());
        $this->assertTrue($variant->isMaster());
    }
            
    public function testGetVariants()
    {
        $product = new Product();
        
        $this->assertEquals(new ArrayCollection(), $product->getVariants());
    }
    
    public function testGetVariantsExcludeMasterVariant()
    {
        $product = new Product();
        $variant = new Variant();
        $masterVariant = new Variant();
        
        $this->assertNotContains($variant, $product->getVariants());
        $this->assertNotContains($masterVariant, $product->getVariants());
        
        $product->addVariant($variant);        
        $product->setMasterVariant($masterVariant);
        
        $this->assertContains($variant, $product->getVariants());
        $this->assertNotContains($masterVariant, $product->getVariants());
    }
      
    public function testAddVariant()
    {
        $product = new Product();
        $variant = new Variant();
        
        $this->assertNotContains($variant, $product->getVariants());
        $this->assertNull($variant->getProduct());
        
        $product->addVariant($variant);
        
        $this->assertContains($variant, $product->getVariants());
        $this->assertSame($product, $variant->getProduct());
    }

    public function testRemoveVariant()
    {
        $product = new Product();
        $variant = new Variant();
        $product->addVariant($variant);
        
        $this->assertContains($variant, $product->getVariants());
        $this->assertSame($product, $variant->getProduct());
        
        $product->removeVariant($variant);
        
        $this->assertNotContains($variant, $product->getVariants());
        $this->assertNull($variant->getProduct());
    }        
    
    public function testHasVariant()
    {
        $product = new Product();
        $variant = new Variant();
        
        $this->assertFalse($product->hasVariant($variant));
        $product->addVariant($variant);
        $this->assertTrue($product->hasVariant($variant));
    }        
            
    /**
     * @dataProvider getSimpleTestData
     */
    public function testSimpleSettersGetters($property, $value, $default)
    {
        $getter = 'get'.$property;
        $setter = 'set'.$property;
        
        $product = new Product();
        
        $this->assertEquals($default, $product->$getter());
        $product->$setter($value);
        $this->assertEquals($value, $product->$getter());
    }
    
    public function getSimpleTestData()
    {
        return array(
            array('Name', 'Product 1', null),
            array('Slug', 'product-1', null),
            array('Description', 'Some product description...', null),
            array('createdAt', new \DateTime(), null),
            array('updatedAt', new \DateTime(), null),            
        );
    }     
    
    public function testToString()
    {
        $product = new Product();
        
        $this->assertEquals('', $product);
        $product->setName('Product 1');
        $this->assertEquals('Product 1', $product);
    }
}
