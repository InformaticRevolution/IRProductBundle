<?php

/*
 * This file is part of the IRProductBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ProductBundle\Manager;

use IR\Bundle\ProductBundle\Model\OptionInterface;

/**
 * Option Manager Interface.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
interface OptionManagerInterface
{   
    /**
     * Creates an empty option instance.
     *
     * @return OptionInterface
     */    
    public function createOption();
    
    /**
     * Updates an option.
     *
     * @param OptionInterface $option
     */
    public function updateOption(OptionInterface $option);    
         
    /**
     * Deletes an option.
     *
     * @param OptionInterface $option
     */
    public function deleteOption(OptionInterface $option);    

    /**
     * Finds an option by the given criteria.
     *
     * @param array $criteria
     *
     * @return OptionInterface|null
     */
    public function findOptionBy(array $criteria);    
    
    /**
     * Returns a collection with all option instances.
     *
     * @return array
     */
    public function findOptions();    
    
    /**
     * Returns the option's fully qualified class name.
     *
     * @return string
     */
    public function getClass(); 
}

