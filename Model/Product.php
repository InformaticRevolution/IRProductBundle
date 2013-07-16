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
 * Abstract product implementation.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
abstract class Product implements ProductInterface, OptionableInterface, VariableInterface
{
    /**
     * @var mixed
     */
    protected $id; 

    /**
     * @var string
     */
    protected $name; 
    
    /**
     * @var string
     */
    protected $slug;    

    /**
     * @var string
     */
    protected $description;
   
    /**
     * @var Collection
     */
    protected $options;    
    
    /**
     * @var Collection
     */
    protected $variants;    
    
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
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = $name;
        
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getSlug()
    {
        return $this->slug;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        
        return $this;
    }    

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return $this->description;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setDescription($description)
    {
        $this->description = $description;
        
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function hasOptions()
    {
        return !$this->getOptions()->isEmpty();        
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
    public function addOption(OptionInterface $option)
    {
        if (!$this->hasOption($option)) {
            $this->getOptions()->add($option);
        }
        
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function removeOption(OptionInterface $option)
    {
        if ($this->hasOption($option)) {
            $this->getOptions()->removeElement($option);
        }
        
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function hasOption(OptionInterface $option)
    {
        return $this->getOptions()->contains($option);
    }     

    /**
     * {@inheritdoc}
     */  
    public function getMasterVariant()
    {
        foreach ($this->getVariants() as $variant) {
            if ($variant->isMaster()) {
                return $variant;
            }
        }        
    }  
    
    /**
     * {@inheritdoc}
     */
    public function setMasterVariant(VariantInterface $variant)
    {
        if ($this->hasVariant($variant)) {
            return $this;
        }        
        
        $variant->setProduct($this);
        $variant->setMaster(true);
        
        $this->getVariants()->add($variant);
        
        return $this;
    }    
    
    /**
     * {@inheritdoc}
     */
    public function getVariants()
    { 
        $variants ?: $this->variants = new ArrayCollection();
        
        return $variants->filter(function (VariantInterface $variant) {
            return !$variant->isMaster();
        });        
    }
    
    /**
     * {@inheritdoc}
     */
    public function addVariant(VariantInterface $variant)
    {
        if (!$this->hasVariant($variant)) {
            $variant->setProduct($this);
            $this->getVariants()->add($variant);
        }
        
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function removeVariant(VariantInterface $variant)
    {
        if ($this->hasVariant($variant)) {
            $this->getVariants()->removeElement($variant);
            $variant->setProduct(null);
        }        
        
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function hasVariant(VariantInterface $variant)
    {
        return $this->getVariants()->contains($variant);
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
    
    /**
     * Returns the string representation of a product.
     *
     * @return string
     */         
    public function __toString()
    {
        return (string) $this->getName();
    }     
}