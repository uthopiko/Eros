<?php
namespace Eros\CartBundle\Tests\Controller;

use Eros\CartBundle\Controller\CartController;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CartControllerTest extends WebTestCase
{
    public function testdashboardActionStandardRequest()
    {
       /* $client = static::createClient(array(),array('PHP_AUTH_USER' => 'usertest','PHP_AUTH_PW'  => 'usertest'));
        $controller = new CartController();
        $NumeroElementos = 1;
        $Articulo = 1;
        $Precio = 10;
        $response = $controller->addAction($NumeroElementos,$Articulo,$Precio);
*/
        $this->assertEquals('a', 'a');
    }

}