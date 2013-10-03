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
 * Product implementation.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class Product implements ProductInterface, OptionableInterface, VariableInterface
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
     * Constructor.
     */    
    public function __construct() 
    {
        $this->options = new ArrayCollection();
        $this->variants = new ArrayCollection();
        $this->createdAt = new \DateTime();
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
    }
    
    /**
     * {@inheritdoc}
     */
    public function hasOptions()
    {
        return !$this->options->isEmpty();        
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
    public function addOption(OptionInterface $option)
    {
        if (!$this->hasOption($option)) {
            $this->options->add($option);
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function removeOption(OptionInterface $option)
    {
        $this->options->removeElement($option);
    }
    
    /**
     * {@inheritdoc}
     */
    public function hasOption(OptionInterface $option)
    {
        return $this->options->contains($option);
    }     

    /**
     * {@inheritdoc}
     */  
    public function getMasterVariant()
    {
        foreach ($this->variants as $variant) {
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

        $this->variants->add($variant);
        
        return $this;
    }    
    
    /**
     * {@inheritdoc}
     */
    public function getVariants()
    {        
        return $this->variants->filter(function (VariantInterface $variant) {
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
            $this->variants->add($variant);
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function removeVariant(VariantInterface $variant)
    {
        if ($this->variants->removeElement($variant)) {
            $variant->setProduct(null);
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function hasVariant(VariantInterface $variant)
    {
        return $this->variants->contains($variant);
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
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    } 

    /**
     * Updates some fields before saving the product.
     */
    public function onPreSave()
    {
        $this->updatedAt = new \DateTime();
    }    
    
    /**
     * Returns the product name.
     *
     * @return string
     */         
    public function __toString()
    {
        return (string) $this->getName();
    }     
}