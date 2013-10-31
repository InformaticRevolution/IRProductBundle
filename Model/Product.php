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
 * Abstract Product implementation.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
abstract class Product implements ProductInterface, OptionableInterface
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
    public function addOption(ProductOptionInterface $option)
    {
        if (!$this->hasOption($option)) {
            $option->setProduct($this);
            $option->setPosition($this->options->count());
            $this->options->add($option);
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function removeOption(ProductOptionInterface $option)
    {
        if ($this->options->removeElement($option)) {
            $option->setProduct(null);
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function hasOption(ProductOptionInterface $option)
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