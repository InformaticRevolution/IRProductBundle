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
 * Product to option relation implementation.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
abstract class ProductOption implements ProductOptionInterface
{
    /**
     * @var mixed
     */
    protected $id;
    
    /**
     * @var ProductInterface
     */
    protected $product;
    
    /**
     * @var OptionInterface
     */
    protected $option;
    
    /**
     * @var integer
     */
    protected $position;
    

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
    public function getProduct()
    {
        return $this->product;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setProduct(ProductInterface $product = null)
    {
        $this->product = $product;
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
    public function setOption(OptionInterface $option)
    {
        $this->option = $option;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getPosition()
    {
        return $this->position;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        $this->assertOptionIsSet();    
        
        return $this->option->getName();
    }

    /**
     * {@inheritdoc}
     */
    public function getPublicName()
    {
        $this->assertOptionIsSet();
        
        return $this->option->getPublicName();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getValues()
    {
        $this->assertOptionIsSet();
        
        return $this->option->getValues();
    }
    
    /**
     * Returns the option public name.
     *
     * @return string
     */         
    public function __toString()
    {
        return (string) $this->getPublicName();
    }       
    
    /**
     * @throws \BadMethodCallException When option is not set
     */
    protected function assertOptionIsSet()
    {
        if (null === $this->option) {
            throw new \BadMethodCallException('The option have to be set in order to access proxy methods.');
        }
    }    
}
