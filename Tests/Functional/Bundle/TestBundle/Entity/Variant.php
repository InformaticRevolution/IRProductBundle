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
use IR\Bundle\ProductBundle\Model\Variant as BaseVariant;

/**
 * @ORM\Entity
 * @ORM\Table(name="variant")
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class Variant extends BaseVariant
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id; 
    
    /**
     * @ORM\ManyToMany(targetEntity="OptionValue")
     * @ORM\JoinTable(name="variants_options",
     *      joinColumns={@ORM\JoinColumn(name="variant_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="option_value_id", referencedColumnName="id", onDelete="CASCADE")}
     * )
     */
    protected $options;       
}
