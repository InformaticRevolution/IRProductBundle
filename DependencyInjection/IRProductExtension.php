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
 * Product Extension.
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
        
        $container->setParameter('ir_product.db_driver', $config['db_driver']);
        $container->setParameter('ir_product.model.product.class', $config['product_class']);
        $container->setParameter('ir_product.template.engine', $config['template']['engine']);
        $container->setParameter('ir_product.backend_type_' . $config['db_driver'], true);
        
        $container->setAlias('ir_product.manager.product', $config['product_manager']);
        
        if (!empty($config['product'])) {
            $this->loadProduct($config['product'], $container, $loader);
        }          
        
        if (!empty($config['option'])) {
            $this->loadOption($config['option'], $container, $loader, $config['db_driver']);
        }        
        
        if (!empty($config['variant'])) {
            $this->loadVariant($config['variant'], $container, $loader, $config['db_driver']);
        }
        
        if ($config['use_variable_product_form_type']) {
            $this->loadVariableProduct($config['product'], $container, $loader);
        }
    }
    
    private function loadProduct(array $config, ContainerBuilder $container, XmlFileLoader $loader)
    {        
        $loader->load('product.xml');
        
        $container->setParameter('ir_product.form.name.product', $config['form']['name']);
        $container->setParameter('ir_product.form.type.product', $config['form']['type']);
        $container->setParameter('ir_product.form.validation_groups.product', $config['form']['validation_groups']);
    }      
    
    private function loadOption(array $config, ContainerBuilder $container, XmlFileLoader $loader, $dbDriver)
    {        
        $loader->load('option.xml');
        $loader->load(sprintf('driver/%s/option.xml', $dbDriver));
 
        $container->setParameter('ir_product.model.option.class', $config['option_class']);
        $container->setParameter('ir_product.model.option_value.class', $config['option_value_class']); 
        $container->setParameter('ir_product.form.name.option', $config['form']['name']);
        $container->setParameter('ir_product.form.type.option', $config['form']['type']);   
        $container->setParameter('ir_product.form.validation_groups.option', $config['form']['validation_groups']);
        
        $container->setAlias('ir_product.manager.option', $config['option_manager']);
    }    
    
    private function loadVariant(array $config, ContainerBuilder $container, XmlFileLoader $loader, $dbDriver)
    {        
        $loader->load('variant.xml');
        $loader->load('variant_validator.xml');
        $loader->load(sprintf('driver/%s/variant.xml', $dbDriver));
        
        $container->setParameter('ir_product.model.variant.class', $config['variant_class']);
        
        $container->setParameter('ir_product.form.name.variant', $config['form']['name']['variant']);
        $container->setParameter('ir_product.form.type.variant', $config['form']['type']['variant']);
        $container->setParameter('ir_product.form.validation_groups.variant', $config['form']['validation_groups']);
        $container->setParameter('ir_product.form.name.master_variant', $config['form']['name']['master_variant']);
        $container->setParameter('ir_product.form.type.master_variant', $config['form']['type']['master_variant']);
        
        $container->setAlias('ir_product.manager.variant', $config['variant_manager']);
    }     
    
    private function loadVariableProduct(array $config, ContainerBuilder $container, XmlFileLoader $loader)
    {
        $loader->load('variable_product.xml');
        
        if ('ir_product' === $config['form']['type']) {
            $container->setParameter('ir_product.form.type.product', 'ir_product_variable_product');
        }
    }    
}
