<?php

/*
 * This file is part of the IRProductBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ProductBundle\Model;

/**
 * Product Interface.
 * 
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
interface ProductInterface
{   
    /**
     * Returns the id.
     * 
     * @return mixed
     */
    public function getId();      

    /**
     * Returns the name.
     *
     * @return string
     */
    public function getName();    
    
    /**
     * Sets the name.
     *
     * @param string $name
     */
    public function setName($name);
    
    /**
     * Returns the slug.
     *
     * @return string
     */
    public function getSlug();    
    
    /**
     * Sets the slug.
     *
     * @param string $slug
     */
    public function setSlug($slug);    

    /**
     * Returns the description.
     *
     * @return string
     */
    public function getDescription();    
    
    /**
     * Sets the description.
     *
     * @param string $description
     */
    public function setDescription($description);
    
    /**
     * Returns the creation time.
     *
     * @return \Datetime
     */
    public function getCreatedAt();   
    
    /**
     * Sets the creation time.
     * 
     * @param \Datetime $createdAt
     */
    public function setCreatedAt(\Datetime $createdAt);    
    
    /**
     * Returns the last update time.
     *
     * @return \Datetime
     */
    public function getUpdatedAt();  
    
    /**
     * Sets the last update time.
     * 
     * @param \Datetime|null $updatedAt
     */
    public function setUpdatedAt(\Datetime $updatedAt = null);  
}

