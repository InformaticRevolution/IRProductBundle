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

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

/**
 * This class contains the configuration information for the bundle.
 *
 * This information is solely responsible for how the different configuration
 * sections are normalized, and merged.
 * 
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ir_product');

        $supportedDrivers = array('orm');
        
        $rootNode
            ->children()
                ->scalarNode('db_driver')
                    ->validate()
                        ->ifNotInArray($supportedDrivers)
                        ->thenInvalid('The driver %s is not supported. Please choose one of '.json_encode($supportedDrivers))
                    ->end()
                    ->cannotBeOverwritten()
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()  
                ->scalarNode('product_class')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('product_manager')->defaultValue('ir_product.manager.product.default')->end()                
            ->end()
        ;            

        $this->addProductSection($rootNode);
        $this->addVariantSection($rootNode);
        $this->addOptionSection($rootNode);
        $this->addTemplateSection($rootNode);
        
        return $treeBuilder;
    }
    
    private function addProductSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('product')
                    ->addDefaultsIfNotSet()
                    ->canBeUnset()
                    ->children()
                        ->arrayNode('form')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('type')->defaultValue('ir_product')->end()
                                ->scalarNode('name')->defaultValue('ir_product_form')->end()               
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }     
    
    private function addVariantSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('variant')
                    ->canBeUnset()
                    ->children()
                        ->scalarNode('variant_class')->isRequired()->cannotBeEmpty()->end()      
                        ->scalarNode('variant_manager')->defaultValue('ir_product.manager.variant.default')->end()
                        ->arrayNode('form')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('type')->defaultValue('ir_product_variant')->end()
                                ->scalarNode('name')->defaultValue('ir_product_variant_form')->end()               
                            ->end()
                        ->end()                   
                    ->end()
                ->end()
            ->end()
        ;
    }     
    
    private function addOptionSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('option')
                    ->canBeUnset()
                    ->children()
                        ->scalarNode('option_class')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('option_value_class')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('option_manager')->defaultValue('ir_product.manager.option.default')->end()
                        ->arrayNode('form')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('type')->defaultValue('ir_product_option')->end()
                                ->scalarNode('name')->defaultValue('ir_product_option_form')->end()               
                            ->end()
                        ->end()                
                    ->end()
                ->end()
            ->end()
        ;
    } 
    
    private function addTemplateSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('template')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('engine')->defaultValue('twig')->end()
                    ->end()
                ->end()
            ->end()
        ;
    }      
}
