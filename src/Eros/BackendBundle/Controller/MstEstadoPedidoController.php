<?php

namespace Eros\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Eros\BackendBundle\Entity\MstEstadoPedido;
use Eros\BackendBundle\Form\MstEstadoPedidoType;

/**
 * MstEstadoPedido controller.
 *
 * @Route("/backend/mstestadopedido")
 */
class MstEstadoPedidoController extends Controller
{
    /**
     * Lists all MstEstadoPedido entities.
     *
     * @Route("/", name="backend_mstestadopedido")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('ErosBackendBundle:MstEstadoPedido')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a MstEstadoPedido entity.
     *
     * @Route("/{id}/show", name="backend_mstestadopedido_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('ErosBackendBundle:MstEstadoPedido')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MstEstadoPedido entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new MstEstadoPedido entity.
     *
     * @Route("/new", name="backend_mstestadopedido_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new MstEstadoPedido();
        $form   = $this->createForm(new MstEstadoPedidoType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new MstEstadoPedido entity.
     *
     * @Route("/create", name="backend_mstestadopedido_create")
     * @Method("post")
     * @Template("ErosBackendBundle:MstEstadoPedido:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new MstEstadoPedido();
        $request = $this->getRequest();
        $form    = $this->createForm(new MstEstadoPedidoType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('backend_mstestadopedido_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing MstEstadoPedido entity.
     *
     * @Route("/{id}/edit", name="backend_mstestadopedido_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('ErosBackendBundle:MstEstadoPedido')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MstEstadoPedido entity.');
        }

        $editForm = $this->createForm(new MstEstadoPedidoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing MstEstadoPedido entity.
     *
     * @Route("/{id}/update", name="backend_mstestadopedido_update")
     * @Method("post")
     * @Template("ErosBackendBundle:MstEstadoPedido:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('ErosBackendBundle:MstEstadoPedido')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MstEstadoPedido entity.');
        }

        $editForm   = $this->createForm(new MstEstadoPedidoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('backend_mstestadopedido_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a MstEstadoPedido entity.
     *
     * @Route("/{id}/delete", name="backend_mstestadopedido_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('ErosBackendBundle:MstEstadoPedido')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find MstEstadoPedido entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('backend_mstestadopedido'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
