<?php

/*
 * This file is part of the IRProductBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ProductBundle\Tests\Functional\Bundle\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use IR\Bundle\ProductBundle\Model\Option as BaseOption;

/**
 * @ORM\Entity
 * @ORM\Table(name="option")
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class Option extends BaseOption
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id; 
    
    /**
     * @ORM\OneToMany(targetEntity="OptionValue", mappedBy="option", cascade={"all"}, orphanRemoval=true)
     */
    protected $values;    
}
