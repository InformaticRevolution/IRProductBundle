<?php

/*
 * This file is part of the IRProductBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ProductBundle\Tests\Controller;

use IR\Bundle\ProductBundle\Tests\Functional\WebTestCase;

/**
 * Product Controller Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class ProductControllerTest extends WebTestCase
{
    const FORM_INTENTION = 'product';
    
    
    protected function setUp()
    {
        parent::setUp();
        
        $this->loadFixtures('product');
    } 
    
    public function testListAction()
    {
        $crawler = $this->client->request('GET', '/products/');

        $this->assertResponseStatusCode(200);
        $this->assertCount(3, $crawler->filter('table tbody tr'));
    }  
    
    public function testShowAction()
    {
        $this->client->request('GET', '/products/1');
        
        $this->assertResponseStatusCode(200);
    }    
    
    public function testNewActionGetMethod()
    {
        $crawler = $this->client->request('GET', '/products/new');
        
        $this->assertResponseStatusCode(200);
        $this->assertCount(1, $crawler->filter('form'));
    }     
    
    public function testNewActionPostMethod()
    {        
        $this->client->request('POST', '/products/new', array(
            'ir_product_form' => array (
                'name' => 'Product 1',
                'options' => array(
                    array('option' => 1)
                ),
                '_token' => $this->generateCsrfToken(static::FORM_INTENTION),
            ) 
        ));  
        
        $this->assertResponseStatusCode(302);
        
        $this->client->followRedirect();
        
        $this->assertResponseStatusCode(200);
        $this->assertCurrentUri('/products/4');
    }      
    
    public function testEditActionGetMethod()
    {   
        $crawler = $this->client->request('GET', '/products/1/edit');
        
        $this->assertResponseStatusCode(200);
        $this->assertCount(1, $crawler->filter('form'));        
    }      
    
    public function testEditActionPostMethod()
    {        
        $this->client->request('POST', '/products/1/edit', array(
            'ir_product_form' => array (
                'name' => 'Product ',              
                '_token' => $this->generateCsrfToken(static::FORM_INTENTION),
            ) 
        ));     
        
        $this->assertResponseStatusCode(302);
        
        $this->client->followRedirect();
        
        $this->assertResponseStatusCode(200);
        $this->assertCurrentUri('/products/1');
    }     
    
    public function testDeleteAction()
    {
        $this->client->request('GET', '/products/1/delete');
        
        $this->assertResponseStatusCode(302);
        
        $crawler = $this->client->followRedirect();
        
        $this->assertResponseStatusCode(200);
        $this->assertCurrentUri('/products/');
        $this->assertCount(2, $crawler->filter('table tbody tr'));
    }  
    
    public function testNotFoundHttpWhenProductNotExist()
    {
        $this->client->request('GET', '/products/4');
        $this->assertResponseStatusCode(404);        
        
        $this->client->request('GET', '/products/4/edit');
        $this->assertResponseStatusCode(404);
        
        $this->client->request('GET', '/products/4/delete');
        $this->assertResponseStatusCode(404);        
    }    
}
