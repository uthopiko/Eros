<?php

namespace Eros\ExtranetBundle\Tests\Entity;

use Eros\ExtranetBundle\Entity\UsrPedidos;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EmpresaPedidoRepositoryTest extends WebTestCase
{
    private $pedidosRepository;

    public function setUp()
    {
        $kernel = static::createKernel();
        $kernel->boot();
        $this->pedidosRepository = $kernel->getContainer()
                                       ->get('doctrine.orm.entity_manager')
                                       ->getRepository('ErosExtranetBundle:EmpresaPedido');
    }

    public function testCountPedidosByCodigoEstado(){
    	$nPedidosProv = $this->pedidosRepository->CountPedidosByCodigoEstado(7,1);
   
        $this->assertEquals(2,$nPedidosProv,'El numero de pedidos pendiente proveedor tiene que ser 2');
    }

    public function testCountPedidosRecibidosByCodigoEstado(){
        $nPedidosProv = $this->pedidosRepository->CountPedidosRecibidosByCodigoEstado(7,1);
        
        $this->assertEquals(2,$nPedidosProv,'El numero de pedidos pendiente proveedor tiene que ser 2');
    }
}
