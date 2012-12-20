<?php

namespace Eros\ExtranetBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CatalogoControllerTest extends WebTestCase
{
    public function testProductoDetails()
    {
       	$client = static::createClient(array(),array('PHP_AUTH_USER' => 'test','PHP_AUTH_PW'  => 'test'));

        $client->request('GET', '/extranet/catalogo/articulo/details/1');
        $response = json_decode($client->getResponse()->getContent());
        $this->assertTrue($client->getResponse()->headers->contains('Content-Type', 'application/json'));
        $this->assertEquals('Articulo Test',$response->articulo->nombre,'La respuesta del articulo deberia ser Articulo Test');
        $this->assertEquals('1',$response->articulo->pidarticulo,'La respuesta del articulo deberia ser Articulo Test');
    }

    public function testEspecificaciones()
    {
       	$client = static::createClient(array(),array('PHP_AUTH_USER' => 'test','PHP_AUTH_PW'  => 'test'));

        $crawler = $client->request('GET', '/extranet/catalogo/articulo/especificaciones/1');

		$numeroConcidencias = $crawler->filter('h1')->count();
		$numeroConcidenciasspecs = $crawler->filter('li')->count();
		
        $this->assertEquals('2',$numeroConcidencias,'La respuesta del articulo deberia ser Articulo Test');
        $this->assertEquals('3',$numeroConcidenciasspecs,'La respuesta del articulo deberia ser Articulo Test');
    }

    public function testEspecificacionesAdd()
    {
       	$client = static::createClient(array(),array('PHP_AUTH_USER' => 'test','PHP_AUTH_PW'  => 'test'));

        $client->request('GET', '/extranet/catalogo/articulo/especificaciones/1/Test/Test/1/add',
        				  array(), array(), array('HTTP_X-Requested-With' => 'XMLHttpRequest'));
        $response = json_decode($client->getResponse()->getContent());
		
		$this->assertTrue($client->getResponse()->headers->contains('Content-Type', 'application/json'));
		$this->assertEquals('Test',$response->item->specification,'La respuesta del articulo deberia ser Articulo Test');
		
		$id = $response->item->id;
		$client->request('GET', '/extranet/catalogo/articulo/especificaciones/'.$id.'/delete');
		$response = json_decode($client->getResponse()->getContent());

        $this->assertTrue($client->getResponse()->headers->contains('Content-Type', 'application/json'));
        $this->assertEquals($id,$response->Spec,'La respuesta del articulo deberia ser Articulo Test');
    }
}
