<?php

namespace Eros\ExtranetBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Eros\ExtranetBundle\Form\Type\ArticuloType;

class DefaultController extends Controller
{
    /**
     * @Route("/index")
     * @Template()
     */
    public function indexAction($name)
    {
        return array('name' => $name);
    }
	
	  /**
     * @Route("/extranet_catalogo_list",name="extranet_catalogo_icon")
     */
    public function ajaxcatalogolistAction()
    {
		$em = $this->get('doctrine.orm.entity_manager');
        $articulo = new \Eros\FrontendBundle\Entity\Article();

        $em = $this->get('doctrine.orm.entity_manager');
        $articulos = $em->getRepository('Eros\FrontendBundle\Entity\Article')->findArticulosByEmpresa('1'); 

        if (!$articulos) {
            $this->get('session')->setFlash('notice', 'No hay articulos en esta empresa.');
        }
        
        return $this->render('ErosExtranetBundle:Catalogo:include/catalogo_lista.inc.html.twig',array('articulos' => $articulos));
    }
	
	  /**
     * @Route("/extranet_catalogo_icon",name="extranet_catalogo_list")
     */
    public function ajaxcatalogoiconAction()
    {
		$em = $this->get('doctrine.orm.entity_manager');
        $articulo = new \Eros\FrontendBundle\Entity\Article();

        $em = $this->get('doctrine.orm.entity_manager');
        $articulos = $em->getRepository('Eros\FrontendBundle\Entity\Article')->findArticulosByEmpresa('1'); 

        if (!$articulos) {
            $this->get('session')->setFlash('notice', 'No hay articulos en esta empresa.');
        }
        
        return $this->render('ErosExtranetBundle:Catalogo:include/catalogo_iconos.inc.html.twig',array('articulos' => $articulos));
    }
    
	
     /**
     * @Route("/save_orden/",name="_save_orden")
     */
    public function saveordenAction()
    {
     /*   $em = $this->get('doctrine.orm.entity_manager');
        $articulos = $em->getRepository('Eros\FrontendBundle\Entity\Article')->findArticulosByEmpresa('1'); 

        if (!$articulos) {
            $this->get('session')->setFlash('notice', 'No hay articulos en esta empresa.');
        }
        */
       $em = $this->get('doctrine.orm.entity_manager');
        if ($_POST) {
		$ids = $_POST["ids"];
		for ($idx = 0; $idx < count($ids); $idx+=1) {
			$id = $ids[$idx];
			$ordinal = $idx;
			$articulos = $em->getRepository('Eros\FrontendBundle\Entity\Article')->updateOrden($id,$ordinal); 
			}

		}
        return new Response("OK");
    }   
    
    
     /**
     * @Route("/ajax_articulo_precio/",name="_ajax_articulo_precio")
     */
    public function ajaxarticuloprecioAction()
    {
		if ($_POST) {
			$SidArticulo = $_POST["SidArticulo"];	
		}
		
		$em = $this->get('doctrine.orm.entity_manager');
        $promocion = new \Eros\FrontendBundle\Entity\CliPromociones();
        
        $articulo = new \Eros\FrontendBundle\Entity\Article();
		$form = $this->get('form.factory')->create(new PromocionesForm(),$promocion,array('attr' => array('id' => '1')));
        
        $articulos = $em->getRepository('Eros\FrontendBundle\Entity\ProPromocionArticulo')->findBysidpromocion('1'); 
        
        return new Response($SidArticulo);
    }
    
     /**
     * @Route("/_ajax_load_parametros/",name="_ajax_load_parametros")
     */
    public function ajaxloadparametrosAction()
    {
		if ($_POST) {
			$SidTipoDescuento = $_POST["SidTipoDescuento"];	
		}
		
		$em = $this->get('doctrine.orm.entity_manager');
        $parametro = new \Eros\BackendBundle\Entity\MstParametrosDescuento();
        
        $lstParametros = $em->getRepository('Eros\BackendBundle\Entity\MstParametrosDescuento')->findBysidtipodescuento($SidTipoDescuento); 
        $html="";
        foreach($lstParametros as $parametro) 
		{ 
		  $html.="<td class=\"parametros\" id=\"param".$parametro->GetId()."\" data-id=\"".$parametro->GetId()."\"><input type=\"text\" name=\"paramname".$parametro->GetId()."\" id=\"paramvalue".$parametro->GetId()."\"></td>";
		}
        
        return new Response($html);
    }
    
    
     /**
     * @Route("/_ajax_load_titulos_parametros/",name="_ajax_load_titulos_parametros")
     */
    public function ajaxloadtitulosparametrosAction()
    {
		if ($_POST) {
			$SidTipoDescuento = $_POST["SidTipoDescuento"];	
		}
		
		$em = $this->get('doctrine.orm.entity_manager');
        $parametro = new \Eros\BackendBundle\Entity\MstParametrosDescuento();
        
        $lstParametros = $em->getRepository('Eros\BackendBundle\Entity\MstParametrosDescuento')->findBysidtipodescuento($SidTipoDescuento); 
        $html="";
        foreach($lstParametros as $parametro) 
		{ 
		  $html.="<td class=\"titparam\">".$parametro->getParametro()."</td>";
		}
        
        return new Response($html);
    }
    
}
