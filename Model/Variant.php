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
     * @var Boolean
     */
    protected $master;    
    
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
        $this->master = false;
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
    public function setProduct(ProductInterface $product = null)
    {
        $this->product = $product;
        
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function isMaster()
    {
        return $this->master;
    }

    /**
     * {@inheritdoc}
     */
    public function setMaster($master)
    {
        $this->master = (Boolean) $master;

        return $this;
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
        
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeOption(OptionValueInterface $option)
    {
        if ($this->hasOption($option)) {
            $this->options->removeElement($option);
        }
        
        return $this;
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