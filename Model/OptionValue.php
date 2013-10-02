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
 * Option Value implementation.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class OptionValue implements OptionValueInterface
{
    /**
     * @var mixed
     */
    private $id; 

    /**
     * @var OptionInterface
     */
    private $option;       
    
    /**
     * @var string
     */
    private $value;      

        
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
    }
    
    /**
     * Returns the value.
     *
     * @return string
     */         
    public function __toString()
    {
        return (string) $this->getValue();
    }       
}