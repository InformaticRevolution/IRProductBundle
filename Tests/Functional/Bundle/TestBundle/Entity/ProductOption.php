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
use IR\Bundle\ProductBundle\Model\ProductOption as BaseProductOption;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="acme_product_products_options", 
 *     uniqueConstraints={@UniqueConstraint(name="product_option_idx", columns={"product_id", "option_id"})}
 * )
 * 
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class ProductOption extends BaseProductOption
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
}
