<?php

namespace Eros\ExtranetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Eros\FrontendBundle\Util\Util;

class MercadoController extends Controller
{

    /**
     * @Route("/compras/list",name="_compras_list",options={"expose"=true})
     */
    public function comprasAction()
    {

        return $this->render('ErosExtranetBundle:Mercado:compras.html.twig');
    }

    /**
     * @Route("/compras/add/{PidArticulo}/{Cantidad}",name="_compras_add",options={"expose"=true})
     */
    public function comprasAddAction($PidArticulo,$Cantidad)
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $user = $this->get('security.context')->getToken()->getUser();
        $userid = $user->GetId();
        $empresa_user = $em->getRepository('Eros\FrontendBundle\Entity\Empresas')->findEmpresaByUser($userid);

        $tarifa=$em->getRepository('Eros\ExtranetBundle\Entity\Tarifa')->findTarifaByArticulo($PidArticulo,$Cantidad); 
        $utilidades = $this->get('eros.utilidades');
        $pedido=new \Eros\ExtranetBundle\Entity\EmpresaPedido();
        $historicopedido=new \Eros\ExtranetBundle\Entity\HistoricoPedido();

        $pedido->setNumeroarticulos($Cantidad);
        $historicopedido->setNumeroarticulos($Cantidad);

        $articulo=$em->getRepository('Eros\FrontendBundle\Entity\Article')->find($PidArticulo);
        $pedido->setArticulo($articulo);

        if($tarifa){
          $pedido->setPrecio($utilidades->getPrecio($articulo->getPrecio(),$tarifa));
          $historicopedido->setPrecio($utilidades->getPrecio($articulo->getPrecio(),$tarifa));

          $pedido->setTarifa($tarifa);
          $historicopedido->setTarifa($tarifa);
        }else{
          $pedido->setPrecio($articulo->getPrecio());
          $historicopedido->setPrecio($articulo->getPrecio());
        }
        
        $pedido->setEmpresa($empresa_user);

        $estado = $em->getRepository('Eros\BackendBundle\Entity\MstEstadoPedido')->find(5);
        $pedido->setEstadopedido($estado);
        $historicopedido->setEstadopedido($estado);

        $pedido->setNumeroarticulos($Cantidad);
        $historicopedido->setNumeroarticulos($Cantidad);

        $pedido->setDateadd(new \DateTime("now"));
        $historicopedido->setDatemodified(new \DateTime("now"));

        $em->persist($pedido);
        $historicopedido->setPedido($pedido);
        $historicopedido->setActive(true);
        $em->persist($historicopedido);
        $em->flush();

        return new Response("OK");
        
    }


    /**
     * @Route("/compras/filter/{pattern}/",name="_compras_filter",options={"expose"=true})
     */
   public function comprasFilterAction($pattern)
      {
          $em = $this->get('doctrine.orm.entity_manager');
          $promocion = new \Eros\CartBundle\Entity\UsrPedidos();
          $request = $this->get('request');
          if ('GET' == $request->getMethod()) {
            $page = $_GET['page']; // get the requested page
            $limit = $_GET['rows']; // get how many rows we want to have into the grid
            $sidx = $_GET['sidx']; // get index row - i.e. user click to sort
            $sord = $_GET['sord']; // get the direction
            if(!$sidx) $sidx =1;
          }
          $user = $this->get('security.context')->getToken()->getUser();
          $userid = $user->GetId();
          $empresa_user = $em->getRepository('Eros\FrontendBundle\Entity\Empresas')->findEmpresaByUser($userid);
          $limitstart=0;
          $limitend=0;

          $articulos = $em->getRepository('ErosFrontendBundle:Article')->findAllAsArray($sidx,$sord,$limitstart,$limitend,$pattern == '*' ? '': $pattern,$empresa_user->GetId());

          $cells = array();
          $i=0;
          foreach($articulos as $articulo){
            $cells[$i]['id']=$articulo['pidarticulo'];
            $cells[$i]['cell']=array($articulo['pidarticulo'],$articulo['nombre'],'',$articulo['precio'],$articulo['nombrecomercial']);
            $i++;
          }

          $response = new Response(json_encode(array(
              'page' => $page,
              'total' => '2',
              'records' => count($articulos),
              'rows' => $cells
          )));
          $response->headers->set('content-type', 'application/json');

          return $response;
      }

     /**
     * @Route("/ventas/list",name="_ventas_list",options={"expose"=true})
     */
    public function ventasAction()
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $promocion = new \Eros\CartBundle\Entity\UsrPedidos();
        $user = $this->get('security.context')->getToken()->getUser();
        $userid = $user->GetId();
        
        $empresa_user = $em->getRepository('Eros\FrontendBundle\Entity\Empresas')->findEmpresaByUser($userid);

        $ventas = $em->getRepository('Eros\CartBundle\Entity\UsrPedidos')->SelectPedidosByEmpresa($empresa_user->GetId()); 
        
        return $this->render('ErosExtranetBundle:Mercado:ventas.html.twig', array('ventas'=>$ventas));
    }

      /**
     * @Route("/clientes/list",name="_clientes_list")
     */
    public function clientesAction()
    {
        $em = $this->get('doctrine.orm.entity_manager');
        if($this->get('security.context')->isGranted('ROLE_BUSSINESS')){
          $user = $this->get('security.context')->getToken()->getUser();
          $userid = $user->GetId();

          $empresa = $em->getRepository('Eros\FrontendBundle\Entity\Empresas')->findByUsuario($userid); 

          $clientes = $em->getRepository('Eros\FrontendBundle\Entity\Empresas')->findUsersClientes($empresa[0]->getId());

          if (!$clientes) {
            $this->get('session')->setFlash('notice', 'No se han encontrado clientes.');
          }

      
          return $this->render('ErosExtranetBundle:Mercado:clientes.html.twig', array('clientes'=>$clientes));
        }
    }
}
