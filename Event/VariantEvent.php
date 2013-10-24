<?php

/*
 * This file is part of the IRProductBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ProductBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use IR\Bundle\ProductBundle\Model\VariantInterface;

/**
 * Variant Event.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class VariantEvent extends Event
{
    /**
     * @var VariantInterface
     */        
    protected $variant;
    
    
   /**
    * Constructor.
    *
    * @param VariantInterface $variant
    */         
    public function __construct(VariantInterface $variant)
    {
        $this->variant = $variant;
    }

    /**
     * Returns the variant.
     * 
     * @return VariantInterface
     */
    public function getVariant()
    {
        return $this->variant;
    }
}