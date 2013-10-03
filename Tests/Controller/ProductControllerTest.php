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

use Nelmio\Alice\Fixtures;
use Symfony\Component\BrowserKit\Client;
use IR\Bundle\ProductBundle\Tests\Functional\WebTestCase;

/**
 * Product Controller Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class ProductControllerTest extends WebTestCase
{
    /**
     * @var Client 
     */
    private $client;


    protected function setUp()
    {
        $this->client = self::createClient();
        $this->importDatabaseSchema();
        $this->loadFixtures();
    } 
        
    public function testListAction()
    {
        $crawler = $this->client->request('GET', '/products/list');

        $this->assertResponseStatusCode(200);
        $this->assertCount(5, $crawler->filter('table tbody tr'));
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
                '_token' => $this->generateCsrfToken(),
            ) 
        ));  
        
        $this->assertResponseStatusCode(302);
        
        $this->client->followRedirect();
        
        $this->assertResponseStatusCode(200);
        $this->assertCurrentUri('/products/6/edit');
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
                '_token' => $this->generateCsrfToken(),
            ) 
        ));     
        
        $this->assertResponseStatusCode(302);
        
        $this->client->followRedirect();
        
        $this->assertResponseStatusCode(200);
        $this->assertCurrentUri('/products/1/edit');
    }     

    public function testDeleteAction()
    {
        $this->client->request('GET', '/products/1/delete');
        
        $this->assertResponseStatusCode(302);
        
        $crawler = $this->client->followRedirect();
        
        $this->assertCurrentUri('/products/list');
        $this->assertCount(4, $crawler->filter('table tbody tr'));
    }      
    
    /**
     * @param integer $statusCode
     */
    protected function assertResponseStatusCode($statusCode)
    {
        $this->assertEquals($statusCode, $this->client->getResponse()->getStatusCode());
    }       
    
    /**
     * @param string $uri
     */
    protected function assertCurrentUri($uri)
    {
        $this->assertStringEndsWith($uri, $this->client->getHistory()->current()->getUri());
    }
    
     /**
      * Generates a CSRF token.
      * 
      * @return string
      */
    protected function generateCsrfToken()
    {
        return $this->client->getContainer()->get('form.csrf_provider')->generateCsrfToken('product');
    }      
    
    /*
     * Loads the test fixtures into the database.
     */    
    protected function loadFixtures()
    {
        Fixtures::load($this->getFixtures(), self::$kernel->getContainer()->get('doctrine.orm.entity_manager'));       
    } 
    
    /**
     * Returns test fixtures.
     * 
     * @return array
     */    
    protected function getFixtures()
    {
        return array(
            'IR\Bundle\ProductBundle\Tests\Functional\Bundle\TestBundle\Entity\Product' => array(
                'produdct{1..5}' => array(
                    'name' => '<sentence(5)>',
                )
            )
        );
    }    
}
