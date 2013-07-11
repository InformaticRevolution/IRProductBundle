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
 * Abstract option implementation.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
abstract class Option implements OptionInterface
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
    protected $publicName;    

    /**
     * @var Collection
     */
    protected $values;    
    
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
        $this->values = new ArrayCollection();
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
        
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getPublicName()
    {
        return $this->publicName;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setPublicName($publicName)
    {
        $this->publicName = $publicName;
        
        return $this;
    }    
    
    /**
     * {@inheritdoc}
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * {@inheritdoc}
     */
    public function addValue(OptionValueInterface $value)
    {
        if (!$this->hasValue($value)) {
            $value->setOption($this);
            $this->values->add($value);
        }
        
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeValue(OptionValueInterface $value)
    {
        if ($this->hasValue($value)) {
            $this->values->removeElement($value);
            $value->setOption(null);
        }
        
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function hasValue(OptionValueInterface $value)
    {
        return $this->values->contains($value);
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
     * Returns the string representation of an option.
     *
     * @return string
     */         
    public function __toString()
    {
        return (string) $this->getName();
    }      
}