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
                ->booleanNode('use_variable_product_form_type')->defaultFalse()->end()
            ->end()
            ->validate()
                ->ifTrue(function($v){ return !empty($v['variant']) && empty($v['option']); })
                ->thenInvalid('The child node "option" must be configured when using "variants".')
            ->end()
            ->validate()
                ->ifTrue(function($v){ return $v['use_variable_product_form_type'] && empty($v['variant']); })
                ->thenInvalid('The child node "variant" must be configured when activating "use_variable_product_form_type".')
            ->end()                        
        ;            

        $this->addProductSection($rootNode);  
        $this->addOptionSection($rootNode);
        $this->addVariantSection($rootNode);
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
                                ->arrayNode('validation_groups')
                                    ->prototype('scalar')->end()
                                    ->defaultValue(array('Product', 'Default'))
                                ->end()                  
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
                                ->arrayNode('validation_groups')
                                    ->prototype('scalar')->end()
                                    ->defaultValue(array('Option', 'Default'))
                                ->end()                 
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
                                ->arrayNode('validation_groups')
                                    ->prototype('scalar')->end()
                                    ->defaultValue(array('Variant', 'Default'))
                                ->end()                
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
