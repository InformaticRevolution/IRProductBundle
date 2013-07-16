<?php

/*
 * This file is part of the IRProductBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ProductBundle\Form\EventListener;

use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Build variant form listener.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class BuildVariantFormListener implements EventSubscriberInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(FormEvents::PRE_SET_DATA => 'preSetData');
    }

    /**
     * Adds fields according to the variant state.
     *
     * @param DataEvent $event
     */
    public function preSetData(FormEvent $event)
    {
        $variant = $event->getData();
        $form = $event->getForm();

        if (null === $variant) {
            return;
        }

        $product = $variant->getProduct();
        
        // We should only be able to select options during the creation process.
        $disabled = null !== $variant->getId();        
        
        if (null !== $product && $product->hasOptions()) {
            $form->add('options', 'ir_product_product_options', array(
                'product' => $product,
                'disabled' => $disabled,
                'label' => 'form.variant.options',
                'translation_domain' => 'ir_product',
            ));
        }
    }
}