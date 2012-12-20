<?php

namespace Eros\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Eros\FrontendBundle\Util\Util;
use Symfony\Component\HttpFoundation\Response;

class EmpresaController extends Controller
{
    /**
     * @Route("/list/",name="_list")
     * @Template()
     */
	public function listAction()
        {
		$em = $this->get('doctrine.orm.entity_manager');
        $empresas = $em->getRepository('Eros\FrontendBundle\Entity\Empresas')->findAll(); 

        if (!$empresas) {
            $this->get('session')->setFlash('notice', 'No se han encontrado empresas.');
        }

        return array('empresas' => $empresas,'items' => 0,'precio' => 0);
	}


	/**
     * @Route("/catalogo/list/{empresa}",name="_catalogo_list",options={"expose"=true})
     */
	public function catalogolistAction($empresa)
        {
		$em = $this->get('doctrine.orm.entity_manager');
        $request = $this->get('request');
       
		$articles = $em->getRepository('Eros\FrontendBundle\Entity\Article')->findArticlesByEmpresa($empresa);     
		 if (!$articles) {
            $this->get('session')->setFlash('articulos', 'No hay articulos en esta empresa.');
            return $this->render('ErosFrontendBundle:Empresa:catalogolist_list.html.twig',array('articulos' => array()));
        }
		foreach ($articles as $param) {
            $empresas[$param['empresaid']] = $param['empresaid'];
        }
        $strEmpresas = implode(',',$empresas);
        $discountPromocion = $em->getRepository('Eros\FrontendBundle\Entity\Article')->findDiscountByPromocion($strEmpresas);
        if ($this->get('security.context')->isGranted('ROLE_USER')) {
            $user = $this->get('security.context')->getToken()->getUser();
            $userid = $user->GetId();
            $clientes = $user->getEmpresasString();
            $arrClientes = explode(',',$clientes);
        }
        else {
            $arrClientes = array(0);
        }   
      
        $articlesReturn = array();
        foreach($articles as $article){
        	$descuentoEmpresa = $this->get('eros.utilidades')->getArrayMaxValue($discountPromocion,'empresa','descuento',$article['empresaid']);
            if (!empty($article['descuento']) && $article['descuento'] > $descuentoEmpresa) {
            	$article['precio_descuento'] =  $article['precio']-$article['precio']*($article['descuento']/100);
            }
            else if ($descuentoEmpresa != null ){
                $article['precio_descuento'] =  $article['precio']-$article['precio']*($descuentoEmpresa/100);
            }
            $articlesReturn [] = $article;
        }
        
        return $this->render('ErosFrontendBundle:Empresa:catalogolist_list.html.twig',array('articulos' => $articlesReturn,'clientes'=>$arrClientes));
	}
	

	/**
     * @Route("/search/article/",name="_search_article")
     */
	public function searchAction()
        {
		$em = $this->get('doctrine.orm.entity_manager');
        $request = $this->get('request');
		 if ('POST' == $request->getMethod()) {
			$pattern = $_POST['searchPattern'];
		}
        //TODO: Añadir filtro de provincia a busqueda
        $provincia = 0;
        $articles = $em->getRepository('Eros\FrontendBundle\Entity\Article')->findArticulosByPattern($pattern,'All',$provincia);     
        if (!$articles) {
            $this->get('session')->setFlash('articulos', 'No hay articulos en esta empresa.');
            return $this->render('ErosFrontendBundle:Empresa:catalogolist_list.html.twig',array('articulos' => array()));
        }
        foreach ($articles as $param) {
            $empresas[$param['empresaid']] = $param['empresaid'];
        }
        $strEmpresas = implode(',',$empresas);
        
        $discount = $em->getRepository('Eros\FrontendBundle\Entity\Article')->findDiscountByArticle($strEmpresas);
        $discountPromocion = $em->getRepository('Eros\FrontendBundle\Entity\Article')->findDiscountByPromocion($strEmpresas);
        $arrParams = array();
        foreach ($discount as $param) {
            $arrParams[$param['pidarticulo']] = $param['value'];
        }
        if($this->get('security.context')->isGranted('ROLE_USER')){
            $user = $this->get('security.context')->getToken()->getUser();
            $userid = $user->GetId();
            $clientes = $user->getEmpresasString();
            $arrClientes = explode(',',$clientes);
        }else{
            $arrClientes = array(0);
        }   

        if($discountPromocion || $arrParams){
            
            $articlesReturn = array();
            foreach($articles as $article){
                if ($discountPromocion) {
                $article['precio_descuento'] =  $article['precio']-$article['precio']*($discountPromocion[0]['descuento']/100);
                }
                else {
                    $article['precio_descuento'] = 0;
                }
                if (array_key_exists($article['pidarticulo'], $arrParams)) {
                    $priceNew = $article['precio']-$article['precio']*($arrParams[$article['pidarticulo']]/100);
                    $article['precio_descuento'] = $article['precio_descuento'] > $priceNew ? $priceNew : $article['precio_descuento'];
                }
                $articlesReturn [] = $article;
            }

        }else{
            foreach($articles as $article){
                $articlesReturn [] = $article;
            }
        }
        //var_dump($articlesReturn);
        return $this->render('ErosFrontendBundle:Empresa:catalogolist_list.html.twig',array('articulos' => $articlesReturn,'clientes'=>$arrClientes));
	}

	/**
     * @Route("/search/article/{pattern}/{field}",name="_search_article_complete",options={"expose"=true})
     */
	public function searchNewAction($pattern, $field)
        {
        $fb = $this->get('fire_php');
		$em = $this->get('doctrine.orm.entity_manager');
        $request = $this->get('request');
        
    	if (isset($pattern) && isset($field)) {
    		$articles = $em->getRepository('Eros\FrontendBundle\Entity\Article')->findArticulosByPattern($pattern,$field,0);     
    		 if (!$articles) {
	            $this->get('session')->setFlash('articulos', 'No hay articulos en esta empresa.');
	            return $this->render('ErosFrontendBundle:Empresa:catalogolist_list.html.twig',array('articulos' => array()));
	        }
    		foreach ($articles as $param) {
	            $empresas[$param['empresaid']] = $param['empresaid'];
	        }
	        $strEmpresas = implode(',',$empresas);
	        $discountPromocion = $em->getRepository('Eros\FrontendBundle\Entity\Article')->findDiscountByPromocion($strEmpresas);
	        if($this->get('security.context')->isGranted('ROLE_USER')){
	            $user = $this->get('security.context')->getToken()->getUser();
	            $userid = $user->GetId();
	            $clientes = $user->getEmpresasString();
	            $arrClientes = explode(',',$clientes);
	        }else{
	            $arrClientes = array(0);
	        }   
	      
	        $articlesReturn = array();
            foreach($articles as $article){
            	$fb->info($article,'Art');
            	$descuentoEmpresa = $this->get('eros.utilidades')->getArrayMaxValue($discountPromocion,'empresa','descuento',$article['empresaid']);
            	$fb->info($descuentoEmpresa,'Desc');
            	$fb->info($article['descuento'],'Descuento2');
                if (!empty($article['descuento']) && $article['descuento'] > $descuentoEmpresa) {
                	$fb->info('1','1');
                	$article['precio_descuento'] =  $article['precio']-$article['precio']*($article['descuento']/100);
                }
                else if ($descuentoEmpresa != null ){
                	$fb->info('2','2');
                    $article['precio_descuento'] =  $article['precio']-$article['precio']*($descuentoEmpresa/100);
                }
                $articlesReturn [] = $article;
            }
	        $fb->info($discountPromocion,'Promocion');
	        $fb->info($articlesReturn,'Articles');
    	}
        
       
            	$fb->info($articles,'Articles');
        return $this->render('ErosFrontendBundle:Empresa:catalogolist_list.html.twig',array('articulos' => $articlesReturn,'clientes'=>$arrClientes));
	}


    /**
     * @Route("/add_cliente/{PidEmpresa}",name="_add_empresa_cliente",options={"expose"=true})
     */
    public function addClienteAction($PidEmpresa)
        {
        $em = $this->get('doctrine.orm.entity_manager');

        if($this->get('security.context')->isGranted('ROLE_USER')){
            $usuario= $this->get('security.context')->getToken()->getUser();

            $usuario->addEmpresas($em->getRepository('Eros\FrontendBundle\Entity\Empresas')->find($PidEmpresa));     
        
            $em->flush();
        }

        return new Response("OK");
    }

    /**
     * @Route("/delete_cliente/{PidEmpresa}",name="_delete_empresa_cliente",options={"expose"=true})
     */
    public function deleteClienteAction($PidEmpresa)
        {
        $em = $this->get('doctrine.orm.entity_manager');

        $usuario= $this->get('security.context')->getToken()->getUser();

        $empresa = $em->getRepository('Eros\FrontendBundle\Entity\Empresas')->find($PidEmpresa);     

        $usuario->removeEmpresas($empresa);
        
        $em->flush();
        return new Response("OK");
    }

    /**
    * @Route("/articulo/details/{PidArticulo}",name="articulo_details")
    */
    public function ArticuloDetailsAction($PidArticulo)
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $articulo = $em->getRepository('Eros\FrontendBundle\Entity\Article')->find($PidArticulo);     

        if(!$articulo){
            $this->get('session')->setFlash('notice', 'No existe ese articulo');
        }
        $fb = $this->get('fire_php');
   		$fb->info('asassa','asassa');

        return $this->render('ErosFrontendBundle:Empresa:Articulo/new_articulodetails.html.twig',array('articulo'=>$articulo));
    }

}
