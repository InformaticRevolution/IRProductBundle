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
use IR\Bundle\ProductBundle\Model\OptionInterface;
use IR\Bundle\ProductBundle\Manager\OptionManager as AbstractOptionManager;

/**
 * Doctrine option manager.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class OptionManager extends AbstractOptionManager
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
     * Updates an option.
     *
     * @param OptionInterface $option
     * @param Boolean         $andFlush Whether to flush the changes (default true)
     */ 
    public function updateOption(OptionInterface $option, $andFlush = true)
    {  
        $this->objectManager->persist($option);
        
        if ($andFlush) {
            $this->objectManager->flush();
        }   
    }

    /**
     * {@inheritDoc}
     */     
    public function deleteOption(OptionInterface $option)
    {
        $this->objectManager->remove($option);
        $this->objectManager->flush();          
    }

    /**
     * {@inheritDoc}
     */
    public function findOptionBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }    
    
    /**
     * {@inheritDoc}
     */
    public function findOptions()
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
