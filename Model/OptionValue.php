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
 * Abstract option value implementation.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
abstract class OptionValue implements OptionValueInterface
{
    /**
     * @var mixed
     */
    protected $id; 

    /**
     * @var OptionInterface
     */
    protected $option;       
    
    /**
     * @var string
     */
    protected $value;      

        
    /**
     * {@inheritdoc}
     */  
    public function getId()
    {
        return $this->id;
    } 

    /**
     * {@inheritdoc}
     */  
    public function getOption()
    {
        return $this->option;
    }

    /**
     * {@inheritdoc}
     */  
    public function setOption(OptionInterface $option = null)
    {
        $this->option = $option;
        
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        return $this->value;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setValue($value)
    {
        $this->value = $value;
        
        return $this;
    }
    
    /**
     * Returns the string representation of a valiue.
     *
     * @return string
     */         
    public function __toString()
    {
        return (string) $this->getValue();
    }       
}