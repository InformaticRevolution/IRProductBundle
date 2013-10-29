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
 * Variant Controller Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class VariantControllerTest extends WebTestCase
{
    const FORM_INTENTION = 'variant';
    
    
    protected function setUp()
    {
        parent::setUp();
        
        $this->loadFixtures('variant');
    } 
    
    public function testShowAction()
    {
        $this->client->request('GET', '/variants/1');
        
        $this->assertResponseStatusCode(200);
    }        
    
    public function testNewActionGetMethod()
    {
        $crawler = $this->client->request('GET', '/variants/new/1');
        
        $this->assertResponseStatusCode(200);
        $this->assertCount(1, $crawler->filter('form'));
    } 
    
    public function testNewActionPostMethod()
    {        
        $this->client->request('POST', '/variants/new/1', array(
            'ir_product_variant_form' => array (
                'options' => array(
                    0 => 2,
                ),
                '_token' => $this->generateCsrfToken(static::FORM_INTENTION),
            ) 
        ));  
        
        $this->assertResponseStatusCode(302);
        
        $this->client->followRedirect();
        
        $this->assertResponseStatusCode(200);
        $this->assertCurrentUri('/products/1');
    }      
    
    public function testEditActionGetMethod()
    {   
        $crawler = $this->client->request('GET', '/variants/1/edit');
        
        $this->assertResponseStatusCode(200);
        $this->assertCount(1, $crawler->filter('form'));        
    }   
    
    public function testEditActionPostMethod()
    {        
        $this->client->request('POST', '/variants/1/edit', array(
            'ir_product_variant_form' => array (
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
        $this->client->request('GET', '/variants/1/delete');
        
        $this->assertResponseStatusCode(302);
        
        $this->client->followRedirect();
        
        $this->assertResponseStatusCode(200);
        $this->assertCurrentUri('/products/1');
    }  
    
    public function testAccessDeniedHttpException()
    {
        $this->client->request('GET', '/variants/2');
        $this->assertResponseStatusCode(403);  
        
        $this->client->request('GET', '/variants/new/2');
        $this->assertResponseStatusCode(403);  
        
        $this->client->request('GET', '/variants/2/edit');
        $this->assertResponseStatusCode(403);  
        
        $this->client->request('GET', '/variants/2/delete');
        $this->assertResponseStatusCode(403);          
    }
    
    public function testNotFoundHttpWhenProductNotExist()
    {
        $this->client->request('GET', '/variants/new/3');
        $this->assertResponseStatusCode(404);       
    }    
    
    public function testNotFoundHttpWhenVariantNotExist()
    {
        $this->client->request('GET', '/variants/3');
        $this->assertResponseStatusCode(404);        
        
        $this->client->request('GET', '/variants/3/edit');
        $this->assertResponseStatusCode(404);
        
        $this->client->request('GET', '/variants/3/delete');
        $this->assertResponseStatusCode(404);        
    }
}
