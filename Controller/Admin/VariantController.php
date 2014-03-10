<?php

/*
 * This file is part of the IRProductBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ProductBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

use IR\Bundle\ProductBundle\IRProductEvents;
use IR\Bundle\ProductBundle\Event\VariantEvent;
use IR\Bundle\ProductBundle\Model\ProductInterface;
use IR\Bundle\ProductBundle\Model\VariantInterface;

/**
 * Admin controller managing the variants.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class VariantController extends ContainerAware
{
    /**
     * Show variant details.
     */
    public function showAction($id)
    {
        $variant = $this->findVariantById($id);

        return $this->container->get('templating')->renderResponse('IRProductBundle:Admin/Variant:show.html.'.$this->getEngine(), array(
            'variant' => $variant
        ));
    }       
    
    /**
     * Create a new variant: show the new form.
     */
    public function newAction(Request $request, $productId)
    {   
        $product = $this->findProductById($productId);
        
        if (!$product->hasOptions()) {
            throw new AccessDeniedHttpException(sprintf('The product with id %s has no options', $productId));            
        }
                
        $variant = $this->container->get('ir_product.manager.variant')->createVariant($product);
        
        $form = $this->container->get('ir_product.form.variant'); 
        $form->setData($variant);
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $product->addVariant($variant);
            $this->container->get('ir_product.manager.product')->updateProduct($product);
            
            /* @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
            $dispatcher = $this->container->get('event_dispatcher');                      
            $dispatcher->dispatch(IRProductEvents::VARIANT_CREATE_COMPLETED, new VariantEvent($variant));
                
            return new RedirectResponse($this->container->get('router')->generate('ir_product_admin_product_show', array('id' => $product->getId())));                      
        }
        
        return $this->container->get('templating')->renderResponse('IRProductBundle:Admin/Variant:new.html.'.$this->getEngine(), array(
            'product' => $product,
            'form' => $form->createView(),
        ));          
    }
  
    /**
     * Edit a variant: show the edit form.
     */
    public function editAction(Request $request, $id)
    {
        $variant = $this->findVariantById($id);

        $form = $this->container->get('ir_product.form.variant');      
        $form->setData($variant);
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $this->container->get('ir_product.manager.product')->updateProduct($variant->getProduct());
            
            /* @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
            $dispatcher = $this->container->get('event_dispatcher');               
            $dispatcher->dispatch(IRProductEvents::VARIANT_EDIT_COMPLETED, new VariantEvent($variant));
                
            return new RedirectResponse($this->container->get('router')->generate('ir_product_admin_product_show', array('id' => $variant->getProduct()->getId())));                     
        }        
        
        return $this->container->get('templating')->renderResponse('IRProductBundle:Admin/Variant:edit.html.'.$this->getEngine(), array(
            'variant' => $variant,
            'form' => $form->createView(),
        ));          
    }      
    
    /**
     * Delete a variant.
     */
    public function deleteAction($id)
    {
        $variant = $this->findVariantById($id);
        $product = $variant->getProduct();
        
        $product->removeVariant($variant);
        $this->container->get('ir_product.manager.product')->updateProduct($product);
        
        /* @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->container->get('event_dispatcher');          
        $dispatcher->dispatch(IRProductEvents::VARIANT_DELETE_COMPLETED, new VariantEvent($variant));
        
        return new RedirectResponse($this->container->get('router')->generate('ir_product_admin_product_show', array('id' => $product->getId())));    
    }           
    
    /**
     * Finds a product by id.
     *
     * @param mixed $id
     *
     * @return ProductInterface
     * 
     * @throws NotFoundHttpException When product does not exist
     */
    protected function findProductById($id)
    {
        $product = $this->container->get('ir_product.manager.product')->findProductBy(array('id' => $id));

        if (null === $product) {
            throw new NotFoundHttpException(sprintf('The product with id %s does not exist', $id));
        }

        return $product;
    } 
    
    /**
     * Finds a variant by id.
     *
     * @param mixed $id
     *
     * @return VariantInterface
     * 
     * @throws NotFoundHttpException When variant does not exist
     */
    protected function findVariantById($id)
    {
        $variant = $this->container->get('ir_product.manager.variant')->findVariantBy(array('id' => $id));

        if (null === $variant) {
            throw new NotFoundHttpException(sprintf('The variant with id %s does not exist', $id));
        }
        
        if ($variant->isMasterVariant()) {
            throw new AccessDeniedHttpException(sprintf('The variant with id %s is a master variant', $id)); 
        }

        return $variant;
    }     
    
    /**
     * Returns the template engine.
     * 
     * @return string
     */    
   protected function getEngine()
    {
        return $this->container->getParameter('ir_product.template.engine');
    }    
}
