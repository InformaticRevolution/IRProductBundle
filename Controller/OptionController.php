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
use IR\Bundle\ProductBundle\Event\OptionEvent;
use IR\Bundle\ProductBundle\Model\OptionInterface;

/**
 * Controller managing the options.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class OptionController extends ContainerAware
{
    /**
     * List all the options.
     */
    public function listAction()
    {
        $options = $this->container->get('ir_product.manager.option')->findOptions();
        
        return $this->container->get('templating')->renderResponse('IRProductBundle:Option:list.html.'.$this->getEngine(), array(
            'options' => $options,
        ));
    }     
    
    /**
     * Create a new option: show the new form.
     */
    public function newAction(Request $request)
    {        
        /* @var $optionManager \IR\Bundle\ProductBundle\Manager\OptionManagerInterface */
        $optionManager = $this->container->get('ir_product.manager.option');
        $option = $optionManager->createOption();

        $form = $this->container->get('ir_product.form.option');       
        $form->setData($option);
        $form->handleRequest($request);
        
        if ($form->isValid()) {            
            $optionManager->updateOption($option);
            
            /* @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
            $dispatcher = $this->container->get('event_dispatcher');            
            $dispatcher->dispatch(IRProductEvents::OPTION_CREATE_COMPLETED, new OptionEvent($option));
                
            return new RedirectResponse($this->container->get('router')->generate('ir_product_option_list'));                      
        }        

        return $this->container->get('templating')->renderResponse('IRProductBundle:Option:new.html.'.$this->getEngine(), array(
            'form' => $form->createView(),
        ));          
    }
  
    /**
     * Edit one option: show the edit form.
     */
    public function editAction(Request $request, $id)
    {
        $option = $this->findOptionById($id);

        $form = $this->container->get('ir_product.form.option');        
        $form->setData($option);
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $this->container->get('ir_product.manager.option')->updateOption($option); 
            
            /* @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
            $dispatcher = $this->container->get('event_dispatcher');               
            $dispatcher->dispatch(IRProductEvents::OPTION_EDIT_COMPLETED, new OptionEvent($option));
                
            return new RedirectResponse($this->container->get('router')->generate('ir_product_option_list'));                      
        }          

        return $this->container->get('templating')->renderResponse('IRProductBundle:Option:edit.html.'.$this->getEngine(), array(
            'option' => $option,
            'form' => $form->createView(),
        ));          
    }    
    
    /**
     * Delete an option.
     */
    public function deleteAction($id)
    {
        $option = $this->findOptionById($id);
        $this->container->get('ir_product.manager.option')->deleteOption($option);
        
        /* @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->container->get('event_dispatcher');              
        $dispatcher->dispatch(IRProductEvents::OPTION_DELETE_COMPLETED, new OptionEvent($option));
        
        return new RedirectResponse($this->container->get('router')->generate('ir_product_option_list'));
    }       
    
    /**
     * Finds an option by id.
     *
     * @param mixed $id
     *
     * @return OptionInterface
     * 
     * @throws NotFoundHttpException When option does not exist
     */
    protected function findOptionById($id)
    {
        $option = $this->container->get('ir_product.manager.option')->findOptionBy(array('id' => $id));

        if (null === $option) {
            throw new NotFoundHttpException(sprintf('The option with id %s does not exist', $id));
        }

        return $option;
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
