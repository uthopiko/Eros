<?php

namespace Eros\ExtranetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Eros\ExtranetBundle\Form\Type\PromocionType;
use Eros\ExtranetBundle\Form\PromocionesForm;
use Eros\ExtranetBundle\Form\Handler\PromocionFormHandler;

class PromocionController extends Controller
{
    /**
     * @Route("/list",name="_promociones_list")
     * @Template()
     */
    public function promocionesAction()
    {
        $fb = $this->get('fire_php');
        $fb->log('Plain Message');
        $em = $this->get('doctrine.orm.entity_manager');
        $promocion = new \Eros\FrontendBundle\Entity\CliPromociones();
    
        $promociones = $em->getRepository('Eros\FrontendBundle\Entity\CliPromociones')->findAll(); 
        
        return $this->render('ErosExtranetBundle:Promociones:promociones.html.twig', array('promociones'=>$promociones));
    }
    
  
    
/*
     /**
     * @Route("/details/{PidPromocion}",name="_promociones_details")
     * @Template()
     *
     *
    public function promocionesdetailsAction($PidPromocion)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $promocion = $em->getRepository('Eros\FrontendBundle\Entity\CliPromociones')->find($PidPromocion);
        $formtype = new PromocionType('1');
        $form = $this->get('form.factory')->create($formtype);
        $formHandler = new PromocionFormHandler($form,$this->get('request'));
        $result = $formHandler->editprocess($promocion,$em);
        $articulos = $em->getRepository('Eros\FrontendBundle\Entity\ProPromocionArticulo')->findBysidpromocion($PidPromocion); 
    
        $request = $this->get('request');
        
        if ('GET' == $request->getMethod()) {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $em->persist($promocion2);
                $em->flush();
                $promocionfrm = $form->getData();
                $articulos = $em->getRepository('Eros\FrontendBundle\Entity\ProPromocionArticulo')->InsertBySidpromocion($promocion->getId(),$promocionfrm->GetTipoDescuento()); 
            }
        }
        //    print_r($promocion);
    return $this->render('ErosExtranetBundle:Promociones:edit.html.twig', array('form' => $form->createView(),'articulos'=>$articulos,'promocion'=>$promocion));
    }*/

      /**
     * @Route("/details/{PidPromocion}",name="_promociones_details")
     * @Template()
     */
    public function promocionesdetailsAction($PidPromocion)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $promocion = $em->getRepository('Eros\FrontendBundle\Entity\CliPromociones')->find($PidPromocion);
        $articulo = new \Eros\FrontendBundle\Entity\Article();
        $user = $this->get('security.context')->getToken()->getUser();
        $userid = $user->GetId();
        $empresaUser = $em->getRepository('Eros\FrontendBundle\Entity\Empresas')->findEmpresaByUser($userid);
        $form = $this->get('form.factory')->create(new PromocionType($empresaUser->GetId()), $promocion);
        
        $articulos = $em->getRepository('Eros\FrontendBundle\Entity\ProPromocionArticulo')->findBysidpromocion($PidPromocion); 
    
        $request = $this->get('request');
    
        if ('POST' == $request->getMethod()) {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $user = $this->get('security.context')->getToken()->getUser();
                $userid = $user->GetId();
                $empresaUser = $em->getRepository('Eros\FrontendBundle\Entity\Empresas')->findEmpresaByUser($userid);

                $promocion->SetEmpresa($empresaUser);
                $em->persist($promocion);
                $em->flush();
            }
        }
        return $this->render('ErosExtranetBundle:Promociones:promocionesdetails.html.twig', array('form' => $form->createView(),'articulos'=>$articulos,'promocion'=>$promocion,'pidpromocion'=>$PidPromocion));
    }

      /**
     * @Route("/add/",name="_promociones_add")
     * @Template()
     */
    public function addAction()
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $user = $this->get('security.context')->getToken()->getUser();
        $userid = $user->GetId();
        $empresaUser = $em->getRepository('Eros\FrontendBundle\Entity\Empresas')->findEmpresaByUser($userid);
        try{
            if(!is_object($empresaUser) || $empresaUser == null){
                $error="Este usuario no tiene empresa asociada";
                throw new \Exception($error);
            }
            $formtype = new PromocionType($empresaUser->GetId());
            $form = $this->get('form.factory')->create($formtype);
            $formHandler = new PromocionFormHandler($form,$this->get('request'),$empresaUser);
            $result = $formHandler->process($em);
            //Si es correcto devuelve un objeto promocion
            if ($result) {
                $parameters = array('PidPromocion' => $result->GetId());
                return new RedirectResponse($this->container->get('router')->generate('_promociones_details',$parameters));
            }
        }catch(\Exception $e){
            echo $e->GetMessage();
            exit(1);
        }
        return $this->render('ErosExtranetBundle:Promociones:new.html.twig', array('form' => $form->createView(),'articulos'=>null));
    }
    
      /**
     * @Route("/borrar_articulo_promo/",name="_borrar_articulo_promo")
     * @Template()
     */
    public function borrarArticuloAction()
    {
       $em = $this->get('doctrine.orm.entity_manager');
       
       $promocion = new \Eros\FrontendBundle\Entity\ProPromocionArticulo();
    if ($_POST) {
      $SidPromocion = $_POST["SidPromocion"];
      $SidArticulo = $_POST["SidArticulo"];     
    }
       $del = $em->getRepository('Eros\FrontendBundle\Entity\ProPromocionArticulo')->Delete($SidArticulo,$SidPromocion); 
   
    $articulos = $em->getRepository('Eros\FrontendBundle\Entity\ProPromocionArticulo')->findBysidpromocion('1'); 
        
       $promocion = new \Eros\FrontendBundle\Entity\CliPromociones();
       $articulo = new \Eros\FrontendBundle\Entity\Article();
       $form = $this->get('form.factory')->create(new PromocionesForm(),$promocion,array('attr' => array('id' => '1')));
         
     return $this->render('ErosExtranetBundle:Promociones:include/articulospromo.inc.html.twig', array('form' => $form->createView(),'articulos' => $articulos));
    }
    
     /**
     * @Route("/agregar_articulo_promo/{PidPromocion}/{PidArticulo}/{Stock}/{PidTipoDescuento}/",name="_agregar_articulo_promo",options={"expose"=true})
     */
    public function agregarArticuloAction($PidPromocion,$PidArticulo,$Stock,$PidTipoDescuento)
    {
        $em = $this->get('doctrine.orm.entity_manager');
       
        $info = $_POST['info'];
        $promocionArticulo = new \Eros\FrontendBundle\Entity\ProPromocionArticulo();
        $promocionArticulo->setSidpromocion($em->getRepository('Eros\FrontendBundle\Entity\CliPromociones')->find($PidPromocion));
        $promocionArticulo->setSidarticulo($em->getRepository('Eros\FrontendBundle\Entity\Article')->find($PidArticulo));
        $promocionArticulo->setTipodescuento($em->getRepository('Eros\BackendBundle\Entity\MstTipoDescuento')->find($PidTipoDescuento));
        $promocionArticulo->setStock($Stock);
        $em->persist($promocionArticulo);
        $em->flush();
        //$del = $em->getRepository('Eros\FrontendBundle\Entity\ProPromocionArticulo')->Agregar($promocionArticulo); 
        foreach($info as $key){
            $promocionParametros = new \Eros\FrontendBundle\Entity\ProPromoArticuloParametros();
            $promocionParametros->setValue($key['value']);
            $promocionParametros->setSidarticulopromocion($em->getRepository('ErosFrontendBundle:ProPromocionArticulo')->find($promocionArticulo->GetId()));
            $promocionParametros->setSidparametrodescuento($em->getRepository('ErosBackendBundle:MstParametrosDescuento')->find($key['id']));
            $em->persist($promocionParametros);
        }

        $em->flush();
        

        $articulos = $em->getRepository('Eros\FrontendBundle\Entity\ProPromocionArticulo')->findBysidpromocion($PidPromocion); 
          
        $promocion = new \Eros\FrontendBundle\Entity\CliPromociones();
        $articulo = new \Eros\FrontendBundle\Entity\Article();
        $form = $this->get('form.factory')->create(new PromocionesForm(),$promocion,array('attr' => array('id' => $PidPromocion)));
           
        return $this->render('ErosExtranetBundle:Promociones:include/articulospromo.inc.html.twig', array('form' => $form->createView(),'articulos' => $articulos,'pidpromocion'=>$PidPromocion));
    }
    
   /**
     * @Route("/select_tipodescuento_ajax/",name="_select_tipodescuento_ajax")
     */
    public function tipodescuentoajaxAction()
    {
    $em = $this->get('doctrine.orm.entity_manager');
    $tdescuento = $em->getRepository('Eros\BackendBundle\Entity\MstTipoDescuento')->findAll();

    return $this->render('ErosFrontendBundle:Maestros:selecttipodescuento.html.twig', array('items' => $tdescuento));
    }
}
