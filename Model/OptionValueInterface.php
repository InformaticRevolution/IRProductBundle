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

/**
 * Option Value Interface.
 * 
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
interface OptionValueInterface
{   
    /**
     * Returns the id.
     * 
     * @return mixed
     */
    public function getId();      

    /**
     * Returns the option.
     *
     * @return OptionInterface
     */
    public function getOption();

    /**
     * Sets the option.
     *
     * @param OptionInterface|null $option
     */
    public function setOption(OptionInterface $option = null);      
    
    /**
     * Returns the value.
     *
     * @return string
     */
    public function getValue();    
    
    /**
     * Sets the value.
     *
     * @param string $value
     */
    public function setValue($value);
    
    /**
     * Returns the position.
     *
     * @return integer
     */
    public function getPosition();    
    
    /**
     * Sets the position.
     *
     * @param string $position
     */
    public function setPosition($position);    
}

