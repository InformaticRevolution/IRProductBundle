<?php

/*
 * This file is part of the IRProductBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ProductBundle\Doctrine\ORM;

use Doctrine\ORM\EntityRepository;

/**
 * Variant Repository.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class VariantRepository extends EntityRepository
{
    /**
     * Finds variants by product joined with options.
     *
     * @param mixed $product
     * 
     * @return array
     */    
    public function findByProductJoinedWithOptions($product)
    {        
        return $this->createQueryBuilder('v')
            ->select('v, o')
            ->innerJoin('v.options', 'o')
            ->where('v.product = :product')
            ->setParameter('product', $product)
            ->getQuery()
            ->getResult()
        ;
    }
}