<?php

/*
 * This file is part of the IRProductBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ProductBundle\EventListener;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Translation\TranslatorInterface;
use IR\Bundle\ProductBundle\IRProductEvents;

/**
 * Flash listener.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class FlashListener implements EventSubscriberInterface
{
    private static $successMessages = array(        
        IRProductEvents::PRODUCT_CREATE_COMPLETED => 'product.flash.created',
        IRProductEvents::PRODUCT_EDIT_COMPLETED => 'product.flash.updated',
        IRProductEvents::PRODUCT_DELETE_COMPLETED => 'product.flash.deleted',
        IRProductEvents::OPTION_CREATE_COMPLETED => 'option.flash.created',
        IRProductEvents::OPTION_EDIT_COMPLETED => 'option.flash.updated',
        IRProductEvents::OPTION_DELETE_COMPLETED => 'option.flash.deleted',         
        IRProductEvents::VARIANT_CREATE_COMPLETED => 'variant.flash.created',
        IRProductEvents::VARIANT_EDIT_COMPLETED => 'variant.flash.updated',      
        IRProductEvents::VARIANT_DELETE_COMPLETED => 'variant.flash.deleted',          
    );

    /**
     * @var SessionInterface
     */    
    protected $session;
    
    /**
     * @var TranslatorInterface
     */    
    protected $translator;

    
   /**
    * Constructor.
    *
    * @param SessionInterface    $session
    * @param TranslatorInterface $translator
    */            
    public function __construct(SessionInterface $session, TranslatorInterface $translator)
    {
        $this->session = $session;
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */        
    public static function getSubscribedEvents()
    {
        return array(
            IRProductEvents::PRODUCT_CREATE_COMPLETED => 'addSuccessFlash',
            IRProductEvents::PRODUCT_EDIT_COMPLETED => 'addSuccessFlash',
            IRProductEvents::PRODUCT_DELETE_COMPLETED => 'addSuccessFlash',
            IRProductEvents::OPTION_CREATE_COMPLETED => 'addSuccessFlash',
            IRProductEvents::OPTION_EDIT_COMPLETED => 'addSuccessFlash',
            IRProductEvents::OPTION_DELETE_COMPLETED => 'addSuccessFlash',               
            IRProductEvents::VARIANT_CREATE_COMPLETED => 'addSuccessFlash',
            IRProductEvents::VARIANT_EDIT_COMPLETED => 'addSuccessFlash',  
            IRProductEvents::VARIANT_DELETE_COMPLETED => 'addSuccessFlash',         
        );
    }

    /**
     * Adds a success flash message.
     * 
     * @param Event $event
     * 
     * @return void
     */            
    public function addSuccessFlash(Event $event)
    {
        if (!isset(self::$successMessages[$event->getName()])) {
            throw new \InvalidArgumentException('This event does not correspond to a known flash message');
        }

        $this->session->getFlashBag()->add('success', $this->trans(self::$successMessages[$event->getName()]));
    }

    /**
     * Translates a message.
     * 
     * @param string $message
     * @param array  $params
     * 
     * @return string
     */       
    private function trans($message, array $params = array())
    {
        return $this->translator->trans($message, $params, 'ir_product');
    }
}