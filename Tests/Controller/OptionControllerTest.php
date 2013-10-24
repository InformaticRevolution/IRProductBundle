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
 * Option Controller Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class OptionControllerTest extends WebTestCase
{
    const FORM_INTENTION = 'option';
    

    protected function setUp()
    {
        parent::setUp();
        
        $this->loadFixtures('option');
    }     
    
    public function testListAction()
    {
        $crawler = $this->client->request('GET', '/options/');

        $this->assertResponseStatusCode(200);
        $this->assertCount(3, $crawler->filter('table tbody tr'));
    }    
    
    public function testNewActionGetMethod()
    {
        $crawler = $this->client->request('GET', '/options/new');
        
        $this->assertResponseStatusCode(200);
        $this->assertCount(1, $crawler->filter('form'));
    } 
    
    public function testNewActionPostMethod()
    {        
        $this->client->request('POST', '/options/new', array(
            'ir_product_option_form' => array (
                'name' => 'T-Shirt Color',
                'publicName' => 'Color',
                '_token' => $this->generateCsrfToken(static::FORM_INTENTION),
            ) 
        ));  
        
        $this->assertResponseStatusCode(302);
        
        $crawler = $this->client->followRedirect();
        
        $this->assertResponseStatusCode(200);
        $this->assertCurrentUri('/options/');
        $this->assertCount(4, $crawler->filter('table tbody tr'));
        $this->assertRegExp('~T-Shirt Color~', $crawler->filter('table tbody')->text());        
    }    
    
    public function testEditActionGetMethod()
    {   
        $crawler = $this->client->request('GET', '/options/1/edit');
        
        $this->assertResponseStatusCode(200);
        $this->assertCount(1, $crawler->filter('form'));        
    }   
    
    public function testEditActionPostMethod()
    {        
        $this->client->request('POST', '/options/1/edit', array(
            'ir_product_option_form' => array (
                'name' => 'T-Shirt Color',
                'publicName' => 'Color',
                '_token' => $this->generateCsrfToken(static::FORM_INTENTION),
            ) 
        ));     
        
        $this->assertResponseStatusCode(302);
        
        $crawler = $this->client->followRedirect();
        
        $this->assertResponseStatusCode(200);
        $this->assertCurrentUri('/options/');
        $this->assertCount(3, $crawler->filter('table tbody tr'));
        $this->assertRegExp('~T-Shirt Color~', $crawler->filter('table tbody')->text());      
    } 
    
    public function testDeleteAction()
    {
        $this->client->request('GET', '/options/1/delete');
        
        $this->assertResponseStatusCode(302);
        
        $crawler = $this->client->followRedirect();
        
        $this->assertResponseStatusCode(200);
        $this->assertCurrentUri('/options/');
        $this->assertCount(2, $crawler->filter('table tbody tr'));
    }   
    
    public function testNotFoundHttpWhenOptionNotExist()
    {
        $this->client->request('GET', '/options/4/edit');
        $this->assertResponseStatusCode(404);
        
        $this->client->request('GET', '/options/4/delete');
        $this->assertResponseStatusCode(404);        
    }     
}
