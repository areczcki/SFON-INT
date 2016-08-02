<?php
/**
 * Created by PhpStorm.
 * User: alexandre
 * Date: 14/05/2016
 * Time: 09:16
 */

namespace SON\UserBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class RegisterControllerTest extends WebTestCase
{

    public function testIndex(){
        $browser = static::createClient();
        $craw = $browser->request("GET", "/register");

        $this->assertEquals(200, $browser->getResponse()->getStatusCode());
        $this->assertTrue($craw->filter('html:contains("Enviar")')->count() > 0);
    }

}