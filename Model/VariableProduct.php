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
 * Abstract Variable Product implementation.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
abstract class VariableProduct extends Product implements VariableProductInterface
{
    /**
     * @var VariantInterface
     */
    protected $masterVariant;
    
    /**
     * @var Collection
     */
    protected $variants;  
    
        
    /**
     * Constructor.
     */    
    public function __construct() 
    {
        parent::__construct();
        
        $this->variants = new ArrayCollection();
    }    

    /**
     * {@inheritdoc}
     */  
    public function getMasterVariant()
    {
        return $this->masterVariant;
    }  
    
    /**
     * {@inheritdoc}
     */
    public function setMasterVariant(VariantInterface $masterVariant)
    {
        $masterVariant->setProduct($this);
        $this->masterVariant = $masterVariant;
    }    
    
    /**
     * {@inheritdoc}
     */
    public function getVariants()
    {   
        $masterVariant = $this->masterVariant;
        
        return $this->variants->filter(function (VariantInterface $variant) use ($masterVariant){
            return $masterVariant !== $variant;
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
}