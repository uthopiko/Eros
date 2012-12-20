<?php

namespace Eros\ExtranetBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProfileControllerTest extends WebTestCase
{
    public function testNotificaciones()
    {
        $client = static::createClient(array(),array('PHP_AUTH_USER' => 'test','PHP_AUTH_PW'  => 'test'));

        $crawler = $client->request('GET', '/extranet/profile/notificaciones');
		$numeroConcidencias = $crawler->filter('#compras:contains("2 compras")')->count();
        $numeroConcidenciasPendiente =  $crawler->filter('#compras-pendientes:contains("0 compras pendientes")')->count();

        //$this->assertEquals('A', $client->getResponse()->getContent(),'El numero de pedidos tiene que ser 1');
        $this->assertEquals(1, $numeroConcidencias,'El numero de pedidos tiene que ser 1');
        $this->assertEquals(1, $numeroConcidenciasPendiente,'El numero de pedidos pendientes tiene que ser 1');
    }
}
