<?php

/*
 * This file is part of the IRProductBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ProductBundle\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use IR\Bundle\ProductBundle\Model\ProductInterface;
use IR\Bundle\ProductBundle\Manager\VariantManager as AbstractVariantManager;

/**
 * Doctrine variant manager.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class VariantManager extends AbstractVariantManager
{
    /**
     * @var ObjectManager
     */          
    protected $objectManager;
    
    /**
     * @var string
     */           
    protected $class;  
    
    
   /**
    * Constructor.
    *
    * @param ObjectManager $om
    * @param string        $class
    */        
    public function __construct(ObjectManager $om, $class)
    {           
        $this->objectManager = $om;
        $this->repository = $om->getRepository($class);
        
        $metadata = $om->getClassMetadata($class);
        $this->class = $metadata->getName();
    }      

    /**
     * {@inheritDoc}
     */
    public function findVariantBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }      
    
    /**
     * {@inheritDoc}
     */    
    public function findVariantsByProductWithOptions(ProductInterface $product)
    {
        return $this->repository->findByProductJoinedWithOptions($product->getId());
    }
    
    /**
     * {@inheritDoc}
     */    
    public function getClass()
    {
        return $this->class;
    }
}
