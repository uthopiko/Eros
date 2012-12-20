<?php

namespace Eros\ExtranetBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Eros\ExtranetBundle\Entity\Tarifa;
use Eros\ExtranetBundle\Form\TarifasForm;

class TarifaController extends Controller
{

     /**
     * @Route("/tarifas/list",name="_tarifas_list",options={"expose"=true})
     */
    public function tarifasAction()
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $promocion = new \Eros\ExtranetBundle\Entity\Tarifa();
    
        $user = $this->get('security.context')->getToken()->getUser();
                $userid = $user->GetId();
                $empresa_user = $em->getRepository('Eros\FrontendBundle\Entity\Empresas')->findEmpresaByUser($userid);
        $tarifas = $em->getRepository('Eros\ExtranetBundle\Entity\Tarifa')->findByEmpresa($empresa_user->GetId()); 
        
        return $this->render('ErosExtranetBundle:Tarifa:tarifas.html.twig', array('tarifas'=>$tarifas));
    }

    /**
     * @Route("/tarifas/articulos/{Tarifa}",name="_tarifa_articulos",options={"expose"=true})
     */
    public function tarifaArticulosAction($Tarifa)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $promocion = new \Eros\ExtranetBundle\Entity\Tarifa();
    
        $user = $this->get('security.context')->getToken()->getUser();
        $userid = $user->GetId();
        $empresa_user = $em->getRepository('Eros\FrontendBundle\Entity\Empresas')->findEmpresaByUser($userid);
        $articulos_tarifas = $em->getRepository('Eros\ExtranetBundle\Entity\Tarifa')->findArticulosNotInTarifa($Tarifa); 
        $articulos_tarifas2 = $em->getRepository('Eros\ExtranetBundle\Entity\Tarifa')->findArticulosInTarifa($Tarifa); 
        
        $cellsarticulosvinc = array();
        $cellsarticulosnovinc = array();
        $i=0;
        foreach($articulos_tarifas as $articulo){
            $cellsarticulosvinc[$articulo['pidarticulo']]=$articulo['nombre'];
            $i++;
        }

        $i=0;
        foreach($articulos_tarifas2 as $articulo){
            $cellsarticulosnovinc[$articulo['pidarticulo']]=$articulo['nombre'];
            $i++;
        }

        $response = new Response(json_encode(array(
              'rows_vinc' => $cellsarticulosvinc,
              'rows_no_vinc' => $cellsarticulosnovinc
        )));
        $response->headers->set('content-type', 'application/json');

        return $response;
    }

     /**
     * @Route("/tarifas/{PidTarifa}/get/descuento",name="_get_descuento",options={"expose"=true})
     */
    public function getDescuentoAction($PidTarifa)
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $tarifas = $em->getRepository('Eros\ExtranetBundle\Entity\Tarifa')->find($PidTarifa); 
        
        return new Response($tarifas->GetDescuento());
    }

    /**
     * Finds and displays a Tarifas entity.
     *
     * @Route("/{id}/show", name="tarifas_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('ErosExtranetBundle:Tarifa')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tarifas entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Muestra la pantallla para crear nuevas tarifas
     *
     * @Route("/new", name="_tarifas_new",options={"expose"=true})
     * @Template()
     */
    public function newAction()
    {
        $entity = new Tarifa();
        $form   = $this->createForm(new TarifasForm(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

     /**
     * Creates a new Tarifas entity.
     *
     * @Route("/create", name="_tarifas_create")
     * @Method("post")
     * @Template("ErosExtranetBundle:Tarifa:new.html.twig")
     */
    public function createAction()
    {
        $peticion = $this->getRequest();
        $entity  = new Tarifa();
        $formulario = $this->createForm(new TarifasForm(), $entity);
         if ($peticion->getMethod() == 'POST') {
                $em = $this->getDoctrine()->getEntityManager();
                     if ($peticion->isXmlHttpRequest()) {  
                         $tarifas_array_form=$peticion->get("TarifasForm");
                         foreach ($tarifas_array_form as $key=>$value){                             
                             if($key=="empresa")
                             {
                                $user = $this->get('security.context')->getToken()->getUser();
                                $userid = $user->GetId();
                                $empresa_user = $em->getRepository('Eros\FrontendBundle\Entity\Empresas')->findEmpresaByUser($userid);
                                $entity->setEmpresa($empresa_user);
                             }                                 
                             else if($key!="_token")
                                $entity->{'set'.ucfirst($key)}( $tarifas_array_form[$key]);
                         }
                         $msg = array();
                        $code = true;
                         /*$errores = $this->get('validator')->validate($aeronave);
                         if (count($errores) > 0) {
                             foreach ($errores as $err) {
                                $msg[$err->getPropertyPath()]= $this->get('translator')->trans($err->getMessage(), array(), 'validators');
                            }
                            $code = false;
                        
                        } else {
                         $code = true;
                        }*/
                        $em->persist($entity);
                        $em->flush();
                        $response = new Response(json_encode(array('code' => $code, 'msg' => $msg,"locale" => $this->get('session')->getLocale())));
                        $response->headers->set('Content-Type', 'application/json');
                        return $response;
                    }
                }//fin si la peticion es por ajax
           /*         
            $formulario->bindRequest($peticion);
            if ($formulario->isValid()) {
                $aeronave = $formulario->getData();
                $em->persist($aeronave);
                $em->flush();
                $peticion->getSession()->setFlash('notice', 'Se ha creado correctamente la aeronave');

                return $this->redirect($this->generateUrl('_AeronauticoBundle_edit', array(
                    'id' => $aeronave->getId()
                )));
            }//fin si es valido
        }//fin post
    
        return $this->render('AeronauticoBundle:Aeronave:new.html.twig', array(
            'form' => $formulario->createView()
        ));*/

    }


    /**
     * Displays a form to edit an existing Tarifas entity.
     *
     * @Route("/{id}/edit", name="tarifas_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('ErosExtranetBundle:Tarifa')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tarifas entity.');
        }

        $editForm = $this->createForm(new TarifasType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Tarifas entity.
     *
     * @Route("/{id}/update", name="tarifas_update")
     * @Method("post")
     * @Template("ErosExtranetBundle:Tarifa:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('ErosExtranetBundle:Tarifa')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tarifas entity.');
        }

        $editForm   = $this->createForm(new TarifasType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tarifas_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Tarifas entity.
     *
     * @Route("/{id}/delete", name="tarifas_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('ErosExtranetBundle:Tarifa')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Tarifas entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tarifas'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
