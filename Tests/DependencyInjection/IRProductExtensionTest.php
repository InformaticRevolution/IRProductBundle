<?php

/*
 * This file is part of the IRProductBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ProductBundle\Tests\DependencyInjection;

use Symfony\Component\Yaml\Parser;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use IR\Bundle\ProductBundle\DependencyInjection\IRProductExtension;

/**
 * Product Extension Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class IRProductExtensionTest extends \PHPUnit_Framework_TestCase
{
    /** 
     * @var ContainerBuilder
     */
    protected $configuration;
    
    
    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testProductLoadThrowsExceptionUnlessDatabaseDriverSet()
    {
        $loader = new IRProductExtension();
        $config = $this->getEmptyConfig();
        unset($config['db_driver']);
        $loader->load(array($config), new ContainerBuilder());
    }  
    
    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testProductLoadThrowsExceptionUnlessDatabaseDriverIsValid()
    {
        $loader = new IRProductExtension();
        $config = $this->getEmptyConfig();
        $config['db_driver'] = 'foo';
        $loader->load(array($config), new ContainerBuilder());
    }    
    
    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testProductLoadThrowsExceptionUnlessProductModelClassSet()
    {
        $loader = new IRProductExtension();
        $config = $this->getEmptyConfig();
        unset($config['product_class']);
        $loader->load(array($config), new ContainerBuilder());
    }     
    
    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testProductLoadThrowsExceptionUnlessOptionModelClassSet()
    {
        $loader = new IRProductExtension();
        $config = $this->getFullConfig();
        unset($config['option']['option_class']);
        $loader->load(array($config), new ContainerBuilder());
    } 
    
    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testProductLoadThrowsExceptionUnlessOptionValueModelClassSet()
    {
        $loader = new IRProductExtension();
        $config = $this->getFullConfig();
        unset($config['option']['option_value_class']);
        $loader->load(array($config), new ContainerBuilder());
    } 
    
    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testProductLoadThrowsExceptionUnlessVariantModelClassSet()
    {
        $loader = new IRProductExtension();
        $config = $this->getFullConfig();
        unset($config['variant']['variant_class']);
        $loader->load(array($config), new ContainerBuilder());
    }    
    
    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testProductLoadThrowsExceptionUnlessOptionSetIfVariantSet()
    {
        $loader = new IRProductExtension();
        $config = $this->getFullConfig();
        unset($config['option']);
        $loader->load(array($config), new ContainerBuilder());        
    }    
    
    public function testDisableProduct()
    {
        $this->configuration = new ContainerBuilder();
        $loader = new IRProductExtension();
        $config = $this->getEmptyConfig();
        $config['product'] = false;
        $loader->load(array($config), $this->configuration);
        $this->assertNotHasDefinition('ir_product.form.product');
    }       
    
    public function testProductLoadModelClassWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertParameter('Acme\ProductBundle\Entity\Product', 'ir_product.model.product.class');
    }        
    
    public function testProductLoadModelClass()
    {
        $this->createFullConfiguration();

        $this->assertParameter('Acme\ProductBundle\Entity\Product', 'ir_product.model.product.class');
    }      
    
    public function testProductLoadManagerClassWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertParameter('orm', 'ir_product.db_driver');
        $this->assertAlias('ir_product.manager.product.default', 'ir_product.manager.product');
        $this->assertNotHasDefinition('ir_product.manager.option');
        $this->assertNotHasDefinition('ir_product.manager.variant');
    }   
    
    public function testProductLoadManagerClass()
    {
        $this->createFullConfiguration();

        $this->assertParameter('orm', 'ir_product.db_driver');
        $this->assertAlias('acme_product.manager.product', 'ir_product.manager.product');
        $this->assertAlias('ir_product.manager.option.default', 'ir_product.manager.option');
        $this->assertAlias('ir_product.manager.variant.default', 'ir_product.manager.variant');
    }       
    
    public function testProductLoadFormClassWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertParameter('ir_product', 'ir_product.form.type.product');
        $this->assertNotHasDefinition('ir_product_form.form.type.option');
        $this->assertNotHasDefinition('ir_product_form.form.type.variant');        
    }      
    
    public function testProductLoadFormClass()
    {
        $this->createFullConfiguration();

        $this->assertParameter('acme_product', 'ir_product.form.type.product');
        $this->assertParameter('acme_product_option', 'ir_product.form.type.option');
        $this->assertParameter('acme_product_variant', 'ir_product.form.type.variant');
    }    

    public function testProductLoadFormNameWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertParameter('ir_product_form', 'ir_product.form.name.product');
        $this->assertNotHasDefinition('ir_product_form.form.name.option');
        $this->assertNotHasDefinition('ir_product_form.form.name.variant');
    }    
    
    public function testProductLoadFormName()
    {
        $this->createFullConfiguration();

        $this->assertParameter('acme_product_form', 'ir_product.form.name.product');
        $this->assertParameter('acme_product_option_form', 'ir_product.form.name.option');
        $this->assertParameter('acme_product_variant_form', 'ir_product.form.name.variant');
    }    
    
    public function testProductLoadFormServiceWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertHasDefinition('ir_product.form.product');
        $this->assertNotHasDefinition('ir_product.form.option');
        $this->assertNotHasDefinition('ir_product.form.variant');
    }     
    
    public function testProductLoadFormService()
    {
        $this->createFullConfiguration();

        $this->assertHasDefinition('ir_product.form.product');
        $this->assertHasDefinition('ir_product.form.option');
        $this->assertHasDefinition('ir_product.form.variant');        
    }        
    
    public function testProductLoadTemplateConfigWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertParameter('twig', 'ir_product.template.engine');
    }      
    
    public function testProductLoadTemplateConfig()
    {
        $this->createFullConfiguration();

        $this->assertParameter('php', 'ir_product.template.engine');
    }       
    
    protected function createEmptyConfiguration()
    {
        $this->configuration = new ContainerBuilder();
        $loader = new IRProductExtension();
        $config = $this->getEmptyConfig();
        $loader->load(array($config), $this->configuration);
        $this->assertTrue($this->configuration instanceof ContainerBuilder);
    }      
    
    protected function createFullConfiguration()
    {
        $this->configuration = new ContainerBuilder();
        $loader = new IRProductExtension();
        $config = $this->getFullConfig();
        $loader->load(array($config), $this->configuration);
        $this->assertTrue($this->configuration instanceof ContainerBuilder);
    }        
    
    /**
     * @return array
     */
    protected function getEmptyConfig()
    {
        $yaml = <<<EOF
db_driver: orm
product_class: Acme\ProductBundle\Entity\Product
EOF;
        $parser = new Parser();

        return $parser->parse($yaml);
    }    
    
    /**
     * @return array
     */    
    protected function getFullConfig()
    {
        $yaml = <<<EOF
db_driver: orm
product_class: Acme\ProductBundle\Entity\Product
product_manager: acme_product.manager.product
product:
    form:
        type: acme_product
        name: acme_product_form
option:
    option_class: Acme\ProductBundle\Entity\Option
    option_value_class: Acme\ProductBundle\Entity\OptionValue
    form:
        type: acme_product_option
        name: acme_product_option_form  
variant:
    variant_class: Acme\ProductBundle\Entity\Variant
    form:
        type: acme_product_variant
        name: acme_product_variant_form              
template:
    engine: php
EOF;
        $parser = new Parser();

        return $parser->parse($yaml);
    }     
    
    /**
     * @param string $value
     * @param string $key
     */
    private function assertAlias($value, $key)
    {
        $this->assertEquals($value, (string) $this->configuration->getAlias($key), sprintf('%s alias is correct', $key));
    }      
    
    /**
     * @param mixed  $value
     * @param string $key
     */
    private function assertParameter($value, $key)
    {
        $this->assertEquals($value, $this->configuration->getParameter($key), sprintf('%s parameter is incorrect', $key));
    }      
    
    /**
     * @param string $id
     */
    private function assertHasDefinition($id)
    {
        $this->assertTrue(($this->configuration->hasDefinition($id) ?: $this->configuration->hasAlias($id)));
    }      
    
    /**
     * @param string $id
     */
    private function assertNotHasDefinition($id)
    {
        $this->assertFalse(($this->configuration->hasDefinition($id) ?: $this->configuration->hasAlias($id)));
    }        
}
