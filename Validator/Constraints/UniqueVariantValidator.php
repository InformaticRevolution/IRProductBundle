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

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

use IR\Bundle\ProductBundle\Model\VariantInterface;
use IR\Bundle\ProductBundle\Manager\VariantManagerInterface;

/**
 * Unique Variant Validator.
 * 
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class UniqueVariantValidator extends ConstraintValidator
{
    /**
     * @var VariantManagerInterface
     */          
    protected $variantManager;
    
    
   /**
    * Constructor.
    *
    * @param VariantManagerInterface $variantManager
    */        
    public function __construct(VariantManagerInterface $variantManager)
    {           
        $this->variantManager = $variantManager;
    }   

    /**
     * {@inheritdoc}
     */       
    public function validate($value, Constraint $constraint)
    {
        if (!$value instanceof VariantInterface) {
            throw new UnexpectedTypeException($value, 'IR\Bundle\ProductBundle\Model\VariantInterface');
        }
        
        $product = $value->getProduct();
        
        if (null === $product || $product->getMasterVariant() === $value) {
            return;
        }
        
        $variants = $this->variantManager->findVariantsByProductWithOptions($product);

        foreach ($variants as $variant) {
            if ($variant === $value) {
                continue;
            }

            if (!count(array_udiff($variant->getOptions()->toArray(), $value->getOptions()->toArray(), 'static::compareOption'))) {
                for ($i=0; $i < count($value->getOptions()); $i++) {
                   $this->context->addViolationAt('options['.$i.']', $constraint->message); 
                }

                return;
            }
        }
    }
    
    private function compareOption($o1, $o2)
    {
        return $o1 !== $o2; 
    }
}
