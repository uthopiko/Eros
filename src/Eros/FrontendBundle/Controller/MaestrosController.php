<?php

namespace Eros\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Eros\FrontendBundle\Util\Util;

class MaestrosController extends Controller
{
    	
    public function listSubCategoriasAction(){
        $em = $this->get('doctrine.orm.entity_manager');
        $pref = $em->getRepository('Eros\FrontendBundle\Entity\SubCategory')->findAll(); 

        if (!$pref) {
            $this->get('session')->setFlash('notice', 'No se han encontrado Subcategorias.');
        }

        return $this->render('ErosFrontendBundle:Maestros:listSubCategorias.html.twig',array('preferencias' => $pref));
    }
    
    /**
     * @Route("/ajax_select_categorias",name="_ajax_select_categorias")
     */
    public function menuCategoriasAction(){
        $em = $this->get('doctrine.orm.entity_manager');
        $pref = $em->getRepository('Eros\FrontendBundle\Entity\Category')->findAll(); 

        if (!$pref) {
            $this->get('session')->setFlash('notice', 'No se han encontrado Subcategorias.');
        }

        return $this->render('ErosFrontendBundle:Maestros:menuCategorias.html.twig',array('items' => $pref));
    }
    
	
	 /**
     * @Route("/ajax_select_subcategorias",name="_ajax_select_subcategorias")
     */
     public function menuSubCategoriasAction(){
        $em = $this->get('doctrine.orm.entity_manager');
        if ($_POST) {
			$SidCategoria = $_POST["SidCategoria"];
		}
        $pref = $em->getRepository('Eros\FrontendBundle\Entity\SubCategory')->findBycategoria($SidCategoria); 
		/*print_r($this->getRequest());*/
        if (!$pref) {
            $this->get('session')->setFlash('notice', 'No se han encontrado Subcategorias.');
        }

        return $this->render('ErosFrontendBundle:Maestros:menuSubCategorias.html.twig',array('items' => $pref));
    }
    
     public function menuEmpresasAction(){
        $em = $this->get('doctrine.orm.entity_manager');
        $pref = $em->getRepository('Eros\FrontendBundle\Entity\Empresas')->findAll(); 

        return $this->render('ErosFrontendBundle:Maestros:menuEmpresas.html.twig',array('items' => $pref));
    }
}
