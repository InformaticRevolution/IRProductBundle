<?php

/*
 * This file is part of the IRProductBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ProductBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use IR\Bundle\ProductBundle\IRProductEvents;
use IR\Bundle\ProductBundle\Event\ProductEvent;
use IR\Bundle\ProductBundle\Model\ProductInterface;

/**
 * Controller managing the products.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class ProductController extends ContainerAware
{
    /**
     * List all the products.
     */
    public function listAction()
    {
        $products = $this->container->get('ir_product.manager.product')->findProducts();

        return $this->container->get('templating')->renderResponse('IRProductBundle:Product:list.html.'.$this->getEngine(), array(
            'products' => $products,
        ));
    }     
    
    /**
     * Show product details.
     */
    public function showAction($id)
    {
        $product = $this->findProductById($id);

        return $this->container->get('templating')->renderResponse('IRProductBundle:Product:show.html.'.$this->getEngine(), array(
            'product' => $product
        ));
    }        
    
    /**
     * Create a new product: show the new form.
     */
    public function newAction(Request $request)
    {       
        /* @var $productManager \IR\Bundle\ProductBundle\Manager\ProductManagerInterface */
        $productManager = $this->container->get('ir_product.manager.product');
        $product = $productManager->createProduct();
        
        $form = $this->container->get('ir_product.form.product'); 
        $form->setData($product);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $productManager->updateProduct($product);
            
            /* @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
            $dispatcher = $this->container->get('event_dispatcher');                      
            $dispatcher->dispatch(IRProductEvents::PRODUCT_CREATE_COMPLETED, new ProductEvent($product));
                
            return new RedirectResponse($this->container->get('router')->generate('ir_product_show', array('id' => $product->getId())));                      
        }
        
        return $this->container->get('templating')->renderResponse('IRProductBundle:Product:new.html.'.$this->getEngine(), array(
            'form' => $form->createView(),
        ));          
    }
  
    /**
     * Edit a product: show the edit form.
     */
    public function editAction(Request $request, $id)
    {
        $product = $this->findProductById($id);

        $form = $this->container->get('ir_product.form.product');      
        $form->setData($product);
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $this->container->get('ir_product.manager.product')->updateProduct($product);
            
            /* @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
            $dispatcher = $this->container->get('event_dispatcher');               
            $dispatcher->dispatch(IRProductEvents::PRODUCT_EDIT_COMPLETED, new ProductEvent($product));
                
            return new RedirectResponse($this->container->get('router')->generate('ir_product_show', array('id' => $product->getId())));                     
        }        
        
        return $this->container->get('templating')->renderResponse('IRProductBundle:Product:edit.html.'.$this->getEngine(), array(
            'product' => $product,
            'form' => $form->createView(),
        ));          
    }    
    
    /**
     * Delete a product.
     */
    public function deleteAction($id)
    {
        $product = $this->findProductById($id);
        $this->container->get('ir_product.manager.product')->deleteProduct($product);
        
        /* @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->container->get('event_dispatcher');          
        $dispatcher->dispatch(IRProductEvents::PRODUCT_DELETE_COMPLETED, new ProductEvent($product));
        
        return new RedirectResponse($this->container->get('router')->generate('ir_product_list'));   
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
     * Returns the template engine.
     * 
     * @return string
     */    
   protected function getEngine()
    {
        return $this->container->getParameter('ir_product.template.engine');
    }    
}
