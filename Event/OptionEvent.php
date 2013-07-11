<?php

/*
 * This file is part of the IRProductBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ProductBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use IR\Bundle\ProductBundle\Model\OptionInterface;

/**
 * Option event.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class OptionEvent extends Event
{
    /**
     * @var OptionInterface
     */        
    protected $option;

    
   /**
    * Constructor.
    *
    * @param OptionInterface $option
    */         
    public function __construct(OptionInterface $option)
    {
        $this->option = $option;
    }

    /**
     * Returns the option.
     * 
     * @return OptionInterface
     */
    public function getOption()
    {
        return $this->option;
    }
}