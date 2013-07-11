<?php

/*
 * This file is part of the IRProductBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ProductBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;

/**
 * Product extension.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class IRProductExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load(sprintf('driver/%s/product.xml', $config['db_driver']));
        
        foreach (array('listener') as $basename) {
            $loader->load(sprintf('%s.xml', $basename));
        }            
        
        $container->setParameter('ir_product.model.product.class', $config['product_class']);
        $container->setParameter('ir_product.template.engine', $config['template']['engine']);
        
        $container->setAlias('ir_product.manager.product', $config['product_manager']);
        
        if (!empty($config['product'])) {
            $this->loadProduct($config['product'], $container, $loader, $config['product_class']);
        }          
        
        if (!empty($config['variant'])) {
            $this->loadVariant($config['variant'], $container, $loader, $config['db_driver']);
        }                  
        
        if (!empty($config['option'])) {
            $this->loadOption($config['option'], $container, $loader, $config['db_driver']);
        }
    }
    
    private function loadProduct(array $config, ContainerBuilder $container, XmlFileLoader $loader, $productClass)
    {        
        $loader->load('product.xml');
        
        $container->setParameter('ir_product.form.name.product', $config['form']['name']);
        $container->setParameter('ir_product.form.type.product', $config['form']['type']);
        
        // Load the product form type according to the concret product model        
        if (class_exists($productClass)) {
            $reflection = new \ReflectionClass($productClass);

            if ($reflection->implementsInterface('\IR\Bundle\ProductBundle\Model\VariableProductInterface')) {
                $container->getDefinition('ir_product.form.type.product')
                    ->setClass($container->getParameter('ir_product.form.type.variable_product.class'))
                ;
            }
        }        
    }      
    
    private function loadVariant(array $config, ContainerBuilder $container, XmlFileLoader $loader, $dbDriver)
    {        
        $loader->load('variant.xml');
        $loader->load(sprintf('driver/%s/variant.xml', $dbDriver));
        
        $container->setParameter('ir_product.model.variant.class', $config['variant_class']);
        $container->setParameter('ir_product.form.name.variant', $config['form']['name']);
        $container->setParameter('ir_product.form.type.variant', $config['form']['type']);
        
        $container->setAlias('ir_product.manager.variant', $config['variant_manager']);
    }     
    
    private function loadOption(array $config, ContainerBuilder $container, XmlFileLoader $loader, $dbDriver)
    {        
        $loader->load('option.xml');
        $loader->load(sprintf('driver/%s/option.xml', $dbDriver));
 
        $container->setParameter('ir_product.model.option.class', $config['option_class']);
        $container->setParameter('ir_product.model.option_value.class', $config['option_value_class']); 
        $container->setParameter('ir_product.form.name.option', $config['form']['name']);
        $container->setParameter('ir_product.form.type.option', $config['form']['type']);   
        
        $container->setAlias('ir_product.manager.option', $config['option_manager']);
    }       
}
