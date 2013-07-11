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
use IR\Bundle\ProductBundle\Manager\ProductManager as AbstractProductManager;

/**
 * Doctrine product manager.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class ProductManager extends AbstractProductManager
{
    /**
     * @var ObjectManager
     */          
    protected $objectManager;
    
    /**
     * @var EntityRepository
     */           
    protected $repository;    

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
     * Updates a product.
     *
     * @param ProductInterface $product
     * @param Boolean          $andFlush Whether to flush the changes (default true)
     */ 
    public function updateProduct(ProductInterface $product, $andFlush = true)
    {  
        $this->objectManager->persist($product);
        
        if ($andFlush) {
            $this->objectManager->flush();
        }   
    }

    /**
     * {@inheritDoc}
     */     
    public function deleteProduct(ProductInterface $product)
    {
        $this->objectManager->remove($product);
        $this->objectManager->flush();          
    }

    /**
     * {@inheritDoc}
     */
    public function findProductBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }    
    
    /**
     * {@inheritDoc}
     */
    public function findProducts()
    {
        return $this->repository->findAll();
    }    
    
    /**
     * {@inheritDoc}
     */    
    public function getClass()
    {
        return $this->class;
    }
}
