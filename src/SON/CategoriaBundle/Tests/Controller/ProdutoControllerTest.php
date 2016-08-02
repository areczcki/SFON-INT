<?php

namespace SON\CategoriaBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProdutoControllerTest extends WebTestCase
{

    public function testIndex(){
        $browser = static::createClient();
        $craw = $browser->request("GET", "/register");

        $this->assertEquals(200, $browser->getResponse()->getStatusCode());
        $this->assertTrue($craw->filter('html:contains("Enviar")')->count() > 0);
    }

}