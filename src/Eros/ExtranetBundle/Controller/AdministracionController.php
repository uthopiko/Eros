<?php

namespace Eros\ExtranetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Eros\FrontendBundle\Util\Util;
use Eros\ExtranetBundle\Form\PedidoType;

class AdministracionController extends Controller
{

    /**
     * @Route("/pedidos/list",name="_pedidos_list",options={"expose"=true})
     */
    public function pedidosAction()
    {

        return $this->render('ErosExtranetBundle:Administracion:pedidos.html.twig');
    }

     /**
     * @Route("/compras/list",name="_compras_list",options={"expose"=true})
     */
    public function comprasAction()
    {

        return $this->render('ErosExtranetBundle:Administracion:pedidoscompras.html.twig');
    }


    /**
     * @Route("/pedidos/filter/{Controlador}",name="_pedidos_filter",options={"expose"=true})
     */
   public function pedidosFilterAction($Controlador)
      {
          $em = $this->get('doctrine.orm.entity_manager');
          $request = $this->get('request');
          if ('GET' == $request->getMethod()) {
            $page = $_GET['page']; // get the requested page
            $limit = $_GET['rows']; // get how many rows we want to have into the grid
            $sidx = $_GET['sidx']; // get index row - i.e. user click to sort
            $sord = $_GET['sord']; // get the direction
            if(!$sidx) $sidx =1;
          }
          $limitstart=0;
          $limitend=0;

          $user = $this->get('security.context')->getToken()->getUser();
          $userid = $user->GetId();
          $empresa_user = $em->getRepository('Eros\FrontendBundle\Entity\Empresas')->findEmpresaByUser($userid);

          if($Controlador=="Pedidos"){
            $empresapedido = $em->getRepository('ErosExtranetBundle:EmpresaPedido')->findAllAsArrayPedidos($sidx,$sord,$limitstart,$limitend,$empresa_user->getId());
          }else{
            $empresapedido = $em->getRepository('ErosExtranetBundle:EmpresaPedido')->findAllAsArrayCompras($sidx,$sord,$limitstart,$limitend,$empresa_user->getId());
          }

          $cells = array();
          $i=0;

          foreach($empresapedido as $item){
            $cells[$i]['id']=$item['id'];
            $cells[$i]['cell']=array($item['id'],$item['estadopedido'],$item['pidtarifa'],$item['nombre'],$item['numeroarticulos'],$item['nombrecomercial'],$item['tarifa'],$item['precio'],$item['precioarticulo'],$item['descuento']);
            $i++;
          }

          $response = new Response(json_encode(array(
              'page' => $page,
              'total' => '2',
              'records' => count($empresapedido),
              'rows' => $cells
          )));
          $response->headers->set('content-type', 'application/json');

          return $response;
      }

    /**
     * @Route("/pedido/details/{PidPedido}/{Nombre}/{Cantidad}/{EmpresaCliente}/{Tarifa}/{Precio}/{EstadoPedido}/{Descuento}/{PrecioArticulo}",name="_pedido_details",options={"expose"=true})
     */
    public function pedidosDetailsAction($PidPedido,$Nombre,$Cantidad,$EmpresaCliente,$Tarifa,$Precio,$EstadoPedido,$Descuento,$PrecioArticulo)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $user = $this->get('security.context')->getToken()->getUser();
        $userid = $user->GetId();
        $empresa_user = $em->getRepository('Eros\FrontendBundle\Entity\Empresas')->findEmpresaByUser($userid);

        $form   = $this->createForm(new PedidoType(),array('attr'=>array('id'=>$empresa_user->GetId())));
       
        $form->get('estadopedido')->setData($em->getRepository('ErosBackendBundle:MstEstadoPedido')->find($EstadoPedido));
        $form->get('tarifa')->setData($em->getRepository('ErosExtranetBundle:Tarifa')->find($Tarifa));
        return $this->render('ErosExtranetBundle:Administracion:pedidodetails.html.twig',array('form'=>$form->createView(),'PidPedido'=>$PidPedido,'articulo'=>$Nombre,'cantidad'=>$Cantidad,'cliente'=>$EmpresaCliente,'precio'=>$Precio,'descuento'=>$Descuento,'precioarticulo'=>$PrecioArticulo));
    }

     /**
     * @Route("/pedido/edit/{PidPedido}",name="_pedido_edit",options={"expose"=true})
     */
    public function pedidosEditAction($PidPedido)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $peticion = $this->getRequest();
        $entity=$em->getRepository('Eros\ExtranetBundle\Entity\EmpresaPedido')->find($PidPedido);
        $em->getRepository('Eros\ExtranetBundle\Entity\EmpresaPedido')->UpdateHistoricoFalse($PidPedido);
        $entity_historica = new \Eros\ExtranetBundle\Entity\HistoricoPedido();
        $user = $this->get('security.context')->getToken()->getUser();
        $userid = $user->GetId();
        $empresa_user = $em->getRepository('Eros\FrontendBundle\Entity\Empresas')->findEmpresaByUser($userid);
        $form = $this->createForm(new PedidoType(),array('attr'=>array('id'=>$empresa_user->GetId())));
        //$historicopedido = $em->getRepository('ErosBackendBundle:MstEstadoPedido')->find($EstadoPedido);
        if ($peticion->getMethod() == 'POST') {
                $em = $this->getDoctrine()->getEntityManager();
                     if ($peticion->isXmlHttpRequest()) {  
                      $tarifas_array_form=$peticion->get("eros_extranetbundle_pedidotype");
                      $form->bindRequest($peticion);
                        $articulo2 = $form->getData();
                         foreach ($tarifas_array_form as $key=>$value){                             
                             if($key=="tarifa")
                             {
                                $tarifa = $em->getRepository('Eros\ExtranetBundle\Entity\Tarifa')->find($tarifas_array_form[$key]);
                                $entity->{'set'.ucfirst($key)}($tarifa);
                                $entity_historica->{'set'.ucfirst($key)}($tarifa);
                             }
                             else if($key=="estadopedido"){
                                $estado = $em->getRepository('Eros\BackendBundle\Entity\MstEstadoPedido')->find($tarifas_array_form[$key]);
                                $entity->{'set'.ucfirst($key)}($estado);
                                $entity_historica->{'set'.ucfirst($key)}($estado);
                             }                               
                             else if($key!="_token"){
                                $entity->{'set'.ucfirst($key)}( $tarifas_array_form[$key]);
                                $entity_historica->{'set'.ucfirst($key)}( $tarifas_array_form[$key]);
                             }
                         }
                         $msg = array();
                        $code = true;

                        $em->merge($entity);
                        $entity_historica->setNumeroarticulos($entity->GetNumeroArticulos());
                        $entity_historica->setDatemodified(new \DateTime("now"));
                        $entity_historica->setPedido($entity);
                        $entity_historica->setActive(true);
                        $em->persist($entity_historica);
                        $em->flush();
                        $response = new Response(json_encode(array('code' => $code, 'msg' => $msg,"locale" => $this->get('session')->getLocale())));
                        $response->headers->set('Content-Type', 'application/json');
                        return $response;
                      }
                }
       }
}
