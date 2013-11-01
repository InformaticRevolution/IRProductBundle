<?php

/*
 * This file is part of the IRProductBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ProductBundle\Validator\Constraints;

use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use IR\Bundle\ProductBundle\Model\ProductOptionInterface;

/**
 * Unique Product Option Collection Validator.
 * 
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class UniqueProductOptionCollectionValidator extends ConstraintValidator
{
    /**
     * {@inheritdoc}
     */       
    public function validate($value, Constraint $constraint)
    {
        if (!$value instanceof Collection) {
            throw new UnexpectedTypeException($value, 'Doctrine\Common\Collections\Collection');
        }
        
        $options = array();
        
        foreach ($value as $productOption) {    
            if (!$productOption instanceof ProductOptionInterface) {
               throw new ValidatorException('Each object in the collection must be of type "IR\Bundle\ProductBundle\Model\ProductOptionInterface"'); 
            }
            
            foreach ($options as $option) {
                if ($option === $productOption->getOption()) {
                    $this->context->addViolation($constraint->message);
                }
            }

            $options[] = $productOption->getOption();
        }
    }
}
