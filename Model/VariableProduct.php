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
 * Abstract variable product implementation.
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
     * {@inheritdoc}
     */  
    public function getMasterVariant()
    {
        return $this->masterVariant;
    }  
    
    /**
     * {@inheritdoc}
     */
    public function setMasterVariant(VariantInterface $variant)
    {
        $variant->setProduct($this);
        $this->masterVariant = $variant;
        
        return $this;
    }    
    
    /**
     * {@inheritdoc}
     */
    public function getVariants()
    { 
        $masterVariant = $this->masterVariant;
        $this->variants ?: $this->variants = new ArrayCollection();
        
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
}