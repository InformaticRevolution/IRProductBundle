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
 * Option implementation.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class Option implements OptionInterface
{
    /**
     * @var mixed
     */
    private $id; 

    /**
     * @var string
     */
    private $name; 
    
    /**
     * @var string
     */
    private $publicName;    

    /**
     * @var Collection
     */
    private $values;    
    
    /**
     * @var \Datetime
     */
    private $createdAt;

    /**
     * @var \Datetime
     */
    private $updatedAt;    
    
       
    /**
     * Constructor.
     */    
    public function __construct() 
    {
        $this->values = new ArrayCollection;
        $this->createdAt = new \DateTime;
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
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    } 

    /**
     * Updates some fields before saving the option.
     */
    public function onPreSave()
    {
        $this->updatedAt = new \DateTime;
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