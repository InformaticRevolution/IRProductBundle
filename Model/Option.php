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
 * Abstract Option implementation.
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
    }

    /**
     * {@inheritdoc}
     */
    public function removeValue(OptionValueInterface $value)
    {
        if ($this->values->removeElement($value)) {
            $value->setOption(null);
        }
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
     * Returns the option public name.
     *
     * @return string
     */         
    public function __toString()
    {
        return (string) $this->getPublicName();
    }      
}