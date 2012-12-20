<?php

namespace Eros\FrontendBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EmpresaControllerTest extends WebTestCase
{
    public function testCatalogoEmpresa()
    {
        $client = static::createClient(array(),array('PHP_AUTH_USER' => 'test','PHP_AUTH_PW'  => 'test'));

        $crawler = $client->request('GET', '/frontend/empresa/catalogo/list/1');
        $numeroConcidencias = $crawler->filter('.product_info')->count();
		
        $this->assertEquals('1',$numeroConcidencias,'La respuesta del articulo deberia ser 1');
    }
}
