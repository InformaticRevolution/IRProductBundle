<?php

/*
 * This file is part of the IRProductBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ProductBundle;

/**
 * Contains all events thrown in the IRProductBundle.
 * 
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
final class IRProductEvents
{    
    /**
     * The PRODUCT_CREATE_COMPLETED event occurs after saving the product in the product creation process.
     *
     * The event listener method receives a IR\Bundle\ProductBundle\Event\ProductEvent instance.
     */
    const PRODUCT_CREATE_COMPLETED = 'ir_product.product.create.completed';
    
    /**
     * The PRODUCT_EDIT_COMPLETED event occurs after saving the product in the product edit process.
     *
     * The event listener method receives a IR\Bundle\ProductBundle\Event\ProductEvent instance.
     */
    const PRODUCT_EDIT_COMPLETED = 'ir_product.product.edit.completed';
    
    /**
     * The PRODUCT_DELETE_COMPLETED event occurs after deleting the product.
     *
     * The event listener method receives a IR\Bundle\ProductBundle\Event\ProductEvent instance.
     */
    const PRODUCT_DELETE_COMPLETED = 'ir_product.product.delete.completed';  
    
    /**
     * The VARIANT_CREATE_COMPLETED event occurs after saving the variant in the variant creation process.
     *
     * The event listener method receives a IR\Bundle\ProductBundle\Event\VariantEvent instance.
     */
    const VARIANT_CREATE_COMPLETED = 'ir_product.variant.create.completed';
    
    /**
     * The VARIANT_EDIT_COMPLETED event occurs after saving the variant in the variant edit process.
     *
     * The event listener method receives a IR\Bundle\ProductBundle\Event\VariantEvent instance.
     */
    const VARIANT_EDIT_COMPLETED = 'ir_product.variant.edit.completed';    
    
    /**
     * The VARIANT_DELETE_COMPLETED event occurs after deleting the variant.
     *
     * The event listener method receives a IR\Bundle\ProductBundle\Event\VariantEvent instance.
     */
    const VARIANT_DELETE_COMPLETED = 'ir_product.variant.delete.completed';      
    
   /**
    * The OPTION_CREATE_COMPLETED event occurs after saving the option in the option creation process.
    *
    * The event listener method receives a IR\Bundle\ProductBundle\Event\OptionEvent instance.
    */
    const OPTION_CREATE_COMPLETED = 'ir_product.option.create.completed';
   
    /**
     * The OPTION_EDIT_COMPLETED event occurs after saving the option in the option edit process.
     *
     * The event listener method receives a IR\Bundle\ProductBundle\Event\OptionEvent instance.
     */
    const OPTION_EDIT_COMPLETED = 'ir_customizable_product.option.edit.completed';
    
    /**
     * The OPTION_DELETE_COMPLETED event occurs after deleting the option.
     *
     * The event listener method receives a IR\Bundle\ProductBundle\Event\OptionEvent instance.
     */
    const OPTION_DELETE_COMPLETED = 'ir_customizable_product.option.delete.completed';    
}