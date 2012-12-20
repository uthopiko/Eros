<?php

namespace Eros\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Eros\BackendBundle\Entity\MstTipoDescuento;
use Eros\BackendBundle\Form\MstTipoDescuentoType;

/**
 * MstTipoDescuento controller.
 *
 * @Route("/backend/msttipodescuento")
 */
class MstTipoDescuentoController extends Controller
{
    /**
     * Lists all MstTipoDescuento entities.
     *
     * @Route("/", name="backend_msttipodescuento")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('ErosBackendBundle:MstTipoDescuento')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a MstTipoDescuento entity.
     *
     * @Route("/{id}/show", name="backend_msttipodescuento_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('ErosBackendBundle:MstTipoDescuento')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MstTipoDescuento entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new MstTipoDescuento entity.
     *
     * @Route("/new", name="backend_msttipodescuento_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new MstTipoDescuento();
        $form   = $this->createForm(new MstTipoDescuentoType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new MstTipoDescuento entity.
     *
     * @Route("/create", name="backend_msttipodescuento_create")
     * @Method("post")
     * @Template("ErosBackendBundle:MstTipoDescuento:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new MstTipoDescuento();
        $request = $this->getRequest();
        $form    = $this->createForm(new MstTipoDescuentoType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('backend_msttipodescuento_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing MstTipoDescuento entity.
     *
     * @Route("/{id}/edit", name="backend_msttipodescuento_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('ErosBackendBundle:MstTipoDescuento')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MstTipoDescuento entity.');
        }

        $editForm = $this->createForm(new MstTipoDescuentoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing MstTipoDescuento entity.
     *
     * @Route("/{id}/update", name="backend_msttipodescuento_update")
     * @Method("post")
     * @Template("ErosBackendBundle:MstTipoDescuento:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('ErosBackendBundle:MstTipoDescuento')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MstTipoDescuento entity.');
        }

        $editForm   = $this->createForm(new MstTipoDescuentoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('backend_msttipodescuento_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a MstTipoDescuento entity.
     *
     * @Route("/{id}/delete", name="backend_msttipodescuento_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('ErosBackendBundle:MstTipoDescuento')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find MstTipoDescuento entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('backend_msttipodescuento'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
