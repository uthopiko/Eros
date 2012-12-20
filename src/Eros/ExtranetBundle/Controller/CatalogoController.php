<?php

namespace Eros\ExtranetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Eros\ExtranetBundle\Form\Type\ArticuloType;

class CatalogoController extends Controller
{
	 /**
     * @Route("/",name="_catalogo")
     */
    public function catalogoAction()
    {
    	$fb = $this->get('fire_php');
		$em = $this->get('doctrine.orm.entity_manager');
        $articulo = new \Eros\FrontendBundle\Entity\Article();
        $form = $this->get('extranet.articulo.form');
        $user = $this->get('security.context')->getToken()->getUser();
        $userid = $user->GetId();
        $request = $this->get('request');
        $empresa_user = $em->getRepository('Eros\FrontendBundle\Entity\Empresas')->findEmpresaByUser($userid);
        if (!$empresa_user) {
            $this->get('session')->setFlash('empresas', 'Se necesita una empresa');
        }
        if ('POST' == $request->getMethod()) {
        	$formHandler =  $this->get('extranet.articulo.form.handler.default');
             $form->bindRequest($request);
            if ($form->isValid()) {
    	        $articulo2 = $form->getData();
    	        $fb->info($articulo2,'Articulo');
 	           	//$articulo = $formHandler->setArticulo($articulo, $form);
			    $articulo2 = $form->getData();
			    if (isset($articulo2['pidarticulo']) && !empty($articulo2['pidarticulo'])) {
			    	$articulo = $em->getRepository('Eros\FrontendBundle\Entity\Article')->find($articulo2['pidarticulo']);
			    }
			    $articulo->setNombre($articulo2['Nombre']);
			    $articulo->setMedida($articulo2['Medidas']);
			    $articulo->setStock($articulo2['Stock']);
			    $articulo->setProducto($em->getRepository('Eros\FrontendBundle\Entity\Product')->find($articulo2['sidproducto']));
			    $articulo->setCategory($articulo2['categoria']);
			    $articulo->setSubcategory($articulo2['subcategoria']);
			    $articulo->setPrecio($articulo2['Precio']);
			    $articulo->setOrden(1500);
                $articulo->file = $articulo2['imagen'];
                $articulo->setPorMayor($articulo2['PorMayor']);
                $articulo->setPorMenor($articulo2['PorMenor']);
			    $articulo->setEmpresa($empresa_user);
                $articulo->setDescription($articulo2['description']);
                $articulo->setUnidadmedida($articulo2['Medidas']);

				$em->persist($articulo);
				$em->flush();
				$valoresMedidas = $request->request->get('ValoresMedidas');
				
				$medidaRemove = $em->getRepository("ErosExtranetBundle:ArticuloMedida")->findByArticulo($articulo->GetPidArticulo());
				foreach ($medidaRemove as $medida) {
					$em->remove($medida);
				}

				if (isset($valoresMedidas)) {
					foreach ($valoresMedidas as $value) {
						$valor = new \Eros\ExtranetBundle\Entity\ArticuloMedida();
						$valor->setValor($em->getRepository('Eros\BackendBundle\Entity\MstValoresMedidas')->find($value));
						$valor->setArticulo($articulo);

						$em->persist($valor);
					}
				}

				$em->flush();

                $this->get('session')->setFlash('notice', 'Message sent!');
           }
        }
        
        $em = $this->get('doctrine.orm.entity_manager');
        $articulos = $em->getRepository('Eros\FrontendBundle\Entity\Article')->findArticulosByEmpresa($empresa_user); 
        
        //echo $serialize;
        if (!$articulos) {
            $this->get('session')->setFlash('notice', 'No hay articulos en esta empresa.');
        }
        
        return $this->render('ErosExtranetBundle:Catalogo:articuloslist.html.twig', 
        					 array('form' => $form->createView(),'articulos' => $articulos));
    }

    /**
    * @Route("/articulo/details/{PidArticulo}",name="_articulo_details",options={"expose"=true})
    */
    public function ProductoDetailsAction($PidArticulo)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $articulo = $em->getRepository('ErosFrontendBundle:Article')->find($PidArticulo);

        /*$response = $this->renderView('ErosExtranetBundle:Catalogo:producto.html.twig', array('articulo'=>$articulo));*/
        //Format articulo in JSON
        $arrArticulo = array(
        	'pidarticulo'=>$articulo->getPidArticulo(),
        	'nombre' => $articulo->getNombre(),
        	'precio'=>$articulo->getPrecio(),
        	'medida'=>$articulo->getMedida(),
        	'stock'=>$articulo->getStock(),
        	'descripcion'=>$articulo->getDescription(),
        	'producto'=> $articulo->getProducto(),
        	'unidadmedida'=>$articulo->getUnidadMedida());
        //$arrArticulo = json_encode($articulo*/
        $response = $this->renderView('ErosExtranetBundle:Catalogo:producto.html.twig', array('articulo'=>$articulo));
        $response = new Response(json_encode(array('status'=>$response,'articulo'=>$arrArticulo)));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }    

    /**
	* @Route("/articulo/especificaciones/{PidArticulo}",name="_articulo_especificaciones")
	* @Template()
	*/
     public function especificacionesAction($PidArticulo)
     {
     	$em = $this->get('doctrine.orm.entity_manager');

     	$specs = $em->getRepository("ErosExtranetBundle:Specs")->findByArticulo($PidArticulo);
        $arrJson = array();
        foreach ($specs as $spec) {
        	$arrJson[$spec->getSection()->getSection()][] = $spec;
        }
        return array('specs'=>$arrJson,'PidArticulo'=>$PidArticulo);
     } 

     /**
      * @Route("/articulo/especificaciones/{PidArticulo}/{NombreSpecification}/{Value}/{Section}/add",name="_spec_add",options={"expose"=true})
	  */
     public function especificacionesAddAction($PidArticulo,$NombreSpecification,$Value,$Section)
     {	
      	$em = $this->get('doctrine.orm.entity_manager');
      	$request = $this->get('request');
      	$spec = new \Eros\ExtranetBundle\Entity\Specs();

      	if ( $request->isXmlHttpRequest()) {
      		$spec->setSpecification($NombreSpecification);
      		$spec->setValue($Value);
      		$spec->setSection($em->getRepository("ErosExtranetBundle:SpecsSection")->find($Section));
      		$spec->setArticulo($em->getRepository("ErosFrontendBundle:Article")->find($PidArticulo));

      		$em->persist($spec);
			$em->flush();
			$id = $spec->getId();
      	}

      	if(isset($id) && !empty($id)){
      		$specArray = $this->get('eros.utilidades')->entityToArray($spec);
      		unset($specArray['section']);
      		$specArray['section '] = $Section;
      		$response = new Response(json_encode(array('status'=>'OK','item'=>$specArray)));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
      	}
      	return false;
     } 


     /**
      * @Route("/articulo/especificaciones/section/{PidArticulo}/{NombreSection}/add",name="_section_add",options={"expose"=true})
	  */
     public function sectionAddAction($PidArticulo,$NombreSection)
     {	
      	$em = $this->get('doctrine.orm.entity_manager');
      	$request = $this->get('request');
      	$section = new \Eros\ExtranetBundle\Entity\SpecsSection();
      	$spec = new \Eros\ExtranetBundle\Entity\Specs();

      	if ( $request->isXmlHttpRequest()) {
      		$section->setSection($NombreSection);
      		$section->setArticulo($em->getRepository("ErosFrontendBundle:Article")->find($PidArticulo));

      		$em->persist($section);
      		$em->flush();
			$pidSection = $section->getId();

      		$spec->setSpecification('Inicial');
      		$spec->setValue('Inicio');
      		$spec->setSection($em->getRepository("ErosExtranetBundle:SpecsSection")->find($pidSection));
      		$spec->setArticulo($em->getRepository("ErosFrontendBundle:Article")->find($PidArticulo));

      		$em->persist($spec);
			$em->flush();
			$id = $spec->getId();
      	}

      	if(isset($id) && !empty($id)){
      		$specArray = $this->get('eros.utilidades')->entityToArray($section);
      		$response = new Response(json_encode(array('status'=>'OK','item'=>$specArray)));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
      	}
      	return false;
     } 


     /**
      * @Route("/articulo/especificaciones/{PidSpec}/delete",name="_spec_delete",options={"expose"=true})
	  */
     public function especificacionesDeleteAction($PidSpec)
     {
      	$em = $this->get('doctrine.orm.entity_manager');
      	$request = $this->get('request');
      	$spec = $em->getRepository("ErosExtranetBundle:Specs")->find($PidSpec);
      	
      	$em->remove($spec);
      	$em->flush();

      	$response = new Response(json_encode(array('status'=>'OK','Spec'=>$PidSpec)));
        $response->headers->set('Content-Type', 'application/json');
      	return $response;

       
     } 

    
}

?>