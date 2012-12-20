<?php

namespace Eros\FrontendBundle\Tests\Entity;

use Eros\FrontendBundle\Entity\UsrPedidos;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArticleRepositoryTest extends WebTestCase
{
    private $articuloRepository;

    public function setUp()
    {
        $kernel = static::createKernel();
        $kernel->boot();
        $this->articuloRepository = $kernel->getContainer()
                                       ->get('doctrine.orm.entity_manager')
                                       ->getRepository('ErosFrontendBundle:Article');
    }

    public function testfindArticulosByPattern(){
        $nArticulos= $this->articuloRepository->findArticulosByPattern('articulo','all','0');

        $this->assertEquals(1,count($nArticulos),'El numero de articulos devueltos mediante la busqueda tiene que ser 1');
    }

    public function testfindArticulosByEmpresa(){
        $nArticulos= $this->articuloRepository->findArticulosByEmpresa('1','20');

        $this->assertEquals(1,count($nArticulos),'El numero de articulos devueltos mediante la busqueda tiene que ser 1');
    }

    public function testfindArticlesByEmpresa(){
        $nArticulos= $this->articuloRepository->findArticlesByEmpresa('1','20');

        $this->assertEquals(1,count($nArticulos),'El numero de articulos devueltos mediante la busqueda tiene que ser 1');
    }

    public function testfindDiscountByPromocion(){
        $nArticulos= $this->articuloRepository->findDiscountByPromocion('1');

        $this->assertEquals(1,count($nArticulos),'El numero de articulos devueltos mediante la busqueda tiene que ser 1');
    }

     public function testfindDiscountByArticle(){
        $resul= $this->articuloRepository->findDiscountByArticle('1');

        $this->assertEquals(50,$resul[0]['value'],'El resultado del descuento debe de ser 50');
        $this->assertEquals(1,count($resul),'El numero de articulos devueltos mediante la busqueda tiene que ser 1');
    }
}
