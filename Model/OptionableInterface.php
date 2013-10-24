<?php

/*
 * This file is part of the IRProductBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ProductBundle\Model;

use Doctrine\Common\Collections\Collection;

/**
 * Optionable Interface.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
interface OptionableInterface
{
    /**
     * Checks whether product has one ore more options.
     *
     * @return Boolean
     */
    public function hasOptions();
    
    /**
     * Returns all the options.
     *
     * @return Collection
     */
    public function getOptions();
    
    /**
     * Adds an option.
     *
     * @param OptionInterface $option
     */
    public function addOption(OptionInterface $option); 
    
    /**
     * Removes an option.
     *
     * @param OptionInterface $option
     */
    public function removeOption(OptionInterface $option);
    
    /**
     * Checks whether product has given option.
     *
     * @param OptionInterface $option
     *
     * @return Boolean
     */
    public function hasOption(OptionInterface $option);    
}