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
 * Abstract variant model.
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
     * @var ProductInterface
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
        
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getSku()
    {
        return $this->sku;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setSku($sku)
    {
        $this->sku = $sku;
        
        return $this;
    }    
    
    /**
     * {@inheritdoc}
     */
    public function getOptions()
    {
        return $this->options ?: $this->options = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function addOption(OptionValueInterface $option)
    {
        if (!$this->hasOption($option)) {
            $this->getOptions()->add($option);
        }
        
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeOption(OptionValueInterface $option)
    {
        if ($this->hasOption($option)) {
            $this->getOptions()->removeElement($option);
        }
        
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function hasOption(OptionValueInterface $option)
    {
        return $this->getOptions()->contains($option);
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
    public function setCreatedAt(\Datetime $datetime)
    {
        $this->createdAt = $datetime;
        
        return $this;
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
    public function setUpdatedAt(\Datetime $datetime = null)
    {
        $this->updatedAt = $datetime;
        
        return $this;
    }    
}