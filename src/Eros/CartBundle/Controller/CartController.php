<?php

namespace Eros\CartBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class CartController extends Controller
{
    /**
     * @Route("/index")
     * @Template()
     */
    public function indexAction()
    {
        return array('name' => 'a');
    }

    /**
     * @Route("/add/{NumeroElementos}/{Articulo}/{Precio}",name="_ajax_add2_pedido",options={"expose"=true})
     */
    public function addAction($NumeroElementos,$Articulo,$Precio)
    {
    	$em = $this->get('doctrine.orm.entity_manager');
        $pedidos = new \Eros\CartBundle\Entity\UsrPedidos();
        $articulo = new \Eros\FrontendBundle\Entity\Article();
        $user= $this->get('security.context')->getToken()->getUser();
		
        $request = $this->get('request');

        if($this->get('security.context')->isGranted('ROLE_USER')){
     http://eros.localhost/cart/cart/       $pedidos->setArticulo($em->getRepository('Eros\FrontendBundle\Entity\Article')->find($Articulo));
            $pedidos->setNumeroarticulos($NumeroElementos);
            $pedidos->setDateadd(new \DateTime("now"));
            $pedidos->setPrecio($Precio);
            $pedidos->setUser($user);
            $pedidos->setSidestadopedido($em->getRepository('Eros\BackendBundle\Entity\MstEstadoPedido')->find(2));
            $em->persist($pedidos);
            $em->flush();
        }else{
            $pedidos->setArticulo($em->getRepository('Eros\FrontendBundle\Entity\Article')->find($Articulo));
            $pedidos->setNumeroarticulos($NumeroElementos);
            $pedidos->setDateadd(new \DateTime("now"));
            $pedidos->setPrecio($Precio);
            $pedidos->setSidestadopedido($em->getRepository('Eros\BackendBundle\Entity\MstEstadoPedido')->find(2));
            $session = $this->getRequest()->getSession();

            // store an attribute for reuse during a later user request
            $session->set('pedidos', $session->get('pedidos').$pedidos->serialize());
            /*var_dump($session->get('pedidos'));*/
        }

        
        
        if($this->get('security.context')->isGranted('ROLE_USER')){
            $items = $em->getRepository('Eros\CartBundle\Entity\UsrPedidos')->CountItemsByUser($user->GetId()); 
            $precio = $em->getRepository('Eros\CartBundle\Entity\UsrPedidos')->SumarPrecioByUser($user->GetId()); 
        }else{
            $items = substr_count($session->get('pedidos'), '{');
            $pedidos_array = explode('{', $session->get('pedidos'));
            $precio = 0;
            for($i=0;$i<count($pedidos_array);$i++){
                $trozos_pedido = explode(',',$pedidos_array[$i]);
               if(count($trozos_pedido)>1){
                    $precio_tmp = $trozos_pedido[3];
                    $nelementos_tmp = $trozos_pedido[2];
                    $precio += $precio_tmp * $nelementos_tmp;
               }               
            }  
        }
        $response = new Response(json_encode(array('status'=>'OK','items'=>$items,'precio'=>$precio." €")));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/list/",name="_cart_list",options={"expose"=true})
     */
    public function listAction()
    {
    	$fb = $this->get('fire_php');
    	$em = $this->get('doctrine.orm.entity_manager');
        $user= $this->get('security.context')->getToken()->getUser();
	
        $pedidos = $em->getRepository('ErosCartBundle:UsrPedidos')->findByUser($user->getId());
  
        return $this->render('ErosCartBundle:Cart:cart.html.twig',array('pedidos'=>$pedidos));
    }
}
