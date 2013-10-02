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
 * Variant implementation.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class Variant implements VariantInterface
{
    /**
     * @var mixed
     */
    private $id; 

    /**
     * @var ProductInterface
     */
    private $product;    

    /**
     * @var Boolean
     */
    private $master;    
    
    /**
     * @var Collection
     */
    private $options;    
    
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
        $this->master = false;
        $this->options = new ArrayCollection;
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
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    
    /**
     * Updates some fields before saving the variant.
     */
    public function onPreSave()
    {
        $this->updatedAt = new \DateTime;
    }    
}