<?php

namespace Eros\CartBundle\Tests\Entity;

use Eros\CartBundle\Entity\UsrPedidos;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UsrPedidosRepositoryTest extends WebTestCase
{
    private $pedidosRepository;

    public function setUp()
    {
        $kernel = static::createKernel();
        $kernel->boot();
        $this->pedidosRepository = $kernel->getContainer()
                                       ->get('doctrine.orm.entity_manager')
                                       ->getRepository('ErosCartBundle:UsrPedidos');
    }

    public function testCountPedidosByEmpresaEstado(){
    	$nPedidosPend = $this->pedidosRepository->CountPedidosByEmpresaEstado(1,1);

        $this->assertEquals(2,$nPedidosPend,'El numero de pedidos pendiente tiene que ser 2');
    }

    public function testSelectPedidosByEmpresa(){
        $nPedidos = $this->pedidosRepository->SelectPedidosByEmpresa(1);

        $this->assertEquals(4,count($nPedidos),'El numero de pedidos tiene que ser 1');
    }

}
