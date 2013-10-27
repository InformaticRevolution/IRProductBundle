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
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Abstract Variant implementation.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
abstract class Variant implements VariantInterface
{
    /**
     * @var mixed
     */
    protected $id; 

    /**
     * @var VariableProductInterface
     */
    protected $product;    

    /**
     * @var Collection
     */
    protected $options;    
    
    /**
     * @var \Datetime
     */
    protected $createdAt;

    /**
     * @var \Datetime
     */
    protected $updatedAt;       
    
    
    /**
     * Constructor.
     */    
    public function __construct() 
    {
        $this->options = new ArrayCollection();
    }

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
    public function setProduct(VariableProductInterface $product = null)
    {
        $this->product = $product;
    }

    /**
     * {@inheritdoc}
     */
    public function isMasterVariant()
    {
        return null !== $this->product && 
               $this === $this->product->getMasterVariant();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * {@inheritdoc}
     */
    public function addOption(OptionValueInterface $option)
    {
        if (!$this->hasOption($option)) {
            $this->options->add($option);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function removeOption(OptionValueInterface $option)
    {
        $this->options->removeElement($option);
    }

    /**
     * {@inheritdoc}
     */
    public function hasOption(OptionValueInterface $option)
    {
        return $this->options->contains($option);
    }    
    
    /**
     * {@inheritdoc}
     */   
    public function getCreatedAt()
    {
        return $this->createdAt;
    }    

    /**
     * {@inheritdoc}
     */   
    public function setCreatedAt(\Datetime $createdAt)
    {
        $this->createdAt = $createdAt;        
    }      
    
    /**
     * {@inheritdoc}
     */   
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    } 

    /**
     * {@inheritdoc}
     */   
    public function setUpdatedAt(\Datetime $updatedAt = null)
    {
        $this->updatedAt = $updatedAt;        
    }       
}