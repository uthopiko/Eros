<?php

namespace Eros\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Eros\FrontendBundle\Util\Util;

class DefaultController extends Controller
{
    /**
     * @Route("/index",name="_frontend_index")
     * @Template()
     */
    public function indexAction()
    {
		$user = $this->container->get('security.context')->getToken()->getUser();
		$user_id= $user->GetId();
        /*return $this->render('ErosFrontendBundle:Default:index2.html.twig', array('name' => $nombre));*/
		
		/*if (null == $ciudad) {
			$ciudad = $this->container->getParameter('cupon.ciudad_por_defecto');
			return new RedirectResponse($this->generateUrl('portada', array('ciudad' => $ciudad)));
		}*/
		$em = $this->getDoctrine()->getEntityManager();
		$hoy = new \DateTime('today');
		$empresas = $em->getRepository('ErosFrontendBundle:User')->findEmpresasByPreferencias($user_id);
		$i=0;
		foreach($empresas as $empresa){
			//Le asignamos 40 puntos que es lo que se le asigna a las empresas que tienen articulos en comun con tus preferencias
			//Posible cambio sumar mas puntos si coincide mas de una preferencia...
			$empresa->setPreferencia(40);
			$arrEmpresa[$empresa->GetId()] = $empresa;
		}
		
		//Sacamos todas las empesas, pero deberia ser desde el principio de la accion solo las que tengan eventos,promociones u ofertas activas, trayendo tambien las subcategorias
		$empresas = $em->getRepository('ErosFrontendBundle:Empresas')->findEmpresasWithPromociones();
		
		$user = $em->getRepository('ErosFrontendBundle:User')->find($user_id);
		// Acceder al servicio
		$utilidades = $this->get('eros.utilidades');
		// Utilizar directamente un m�todo del servicio
		foreach($empresas as $empresa){
			//Le asignamos 40 puntos que es lo que se le asigna a las empresas que tienen articulos en comun con tus preferencias
			//Posible cambio sumar mas puntos si coincide mas de una preferencia...
			$distancia = $utilidades->getDistancia($user->GetLocalidad(),$empresa->GetLocalidad());
			$dist_km = round($distancia/1000);
			if($dist_km<10)
				$empresa->setPreferencia((array_key_exists($empresa->GetId(),$arrEmpresa) ? $arrEmpresa[$empresa->GetId()]->GetPreferencia() : 0) + 40);
			else if($dist_km<50)
				$empresa->setPreferencia((array_key_exists($empresa->GetId(),$arrEmpresa) ? $arrEmpresa[$empresa->GetId()]->GetPreferencia() : 0) + 35);
			else if($dist_km<100)
				$empresa->setPreferencia((array_key_exists($empresa->GetId(),$arrEmpresa) ? $arrEmpresa[$empresa->GetId()]->GetPreferencia() : 0) + 30);
			else if($dist_km<300)
				$empresa->setPreferencia((array_key_exists($empresa->GetId(),$arrEmpresa) ? $arrEmpresa[$empresa->GetId()]->GetPreferencia() : 0) + 20);
			else if($dist_km>=300)
				$empresa->setPreferencia((array_key_exists($empresa->GetId(),$arrEmpresa) ? $arrEmpresa[$empresa->GetId()]->GetPreferencia() : 0) + 10);
			$arrEmpresa[$empresa->GetId()] = $empresa;
		}
		
		$promocion = $em->getRepository('ErosFrontendBundle:CliPromociones')->findBy(array('empresa' => '1'));

		return $this->render('ErosFrontendBundle:Default:index.html.twig', array('ofertas' => $promocion));
	}
	
	/**
	* @Route("/cart/",name="_cart_layout")
    * @Template()
    */
    public function cartAction()
    {
    	$em = $this->get('doctrine.orm.entity_manager');
 
        $user= $this->get('security.context')->getToken()->getUser();
        if($this->get('security.context')->isGranted('ROLE_USER')){
            $items = $em->getRepository('Eros\CartBundle\Entity\UsrPedidos')->CountItemsByUser($user->GetId()); 
            $precio = $em->getRepository('Eros\CartBundle\Entity\UsrPedidos')->SumarPrecioByUser($user->GetId());
        }else{
        	$session = $this->getRequest()->getSession();
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

        return array('items'=>$items,'precio'=>$precio);
    }   

     /**
     * @Route("/portada/",name="_portada")
     * @Template()
     */
    public function portadaAction()
    {
        return $this->render('ErosFrontendBundle:Default:portada.html.twig');
    }

     /**
     * @Route("/select/",name="_select")
     */
    public function selectAction()
    {
        return $this->render('ErosFrontendBundle:Default:select.html.twig');
    }
}
