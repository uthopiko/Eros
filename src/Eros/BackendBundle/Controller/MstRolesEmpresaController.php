<?php

namespace Eros\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Eros\BackendBundle\Entity\MstRolesEmpresa;
use Eros\BackendBundle\Form\MstRolesEmpresaType;

/**
 * MstRolesEmpresa controller.
 *
 * @Route("/backend/maestros/roles")
 */
class MstRolesEmpresaController extends Controller
{
    /**
     * Lists all MstRolesEmpresa entities.
     *
     * @Route("/", name="backend_maestros_roles")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('ErosBackendBundle:MstRolesEmpresa')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a MstRolesEmpresa entity.
     *
     * @Route("/{id}/show", name="backend_maestros_roles_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('ErosBackendBundle:MstRolesEmpresa')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MstRolesEmpresa entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new MstRolesEmpresa entity.
     *
     * @Route("/new", name="backend_maestros_roles_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new MstRolesEmpresa();
        $form   = $this->createForm(new MstRolesEmpresaType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new MstRolesEmpresa entity.
     *
     * @Route("/create", name="backend_maestros_roles_create")
     * @Method("post")
     * @Template("ErosBackendBundle:MstRolesEmpresa:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new MstRolesEmpresa();
        $request = $this->getRequest();
        $form    = $this->createForm(new MstRolesEmpresaType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('backend_maestros_roles_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing MstRolesEmpresa entity.
     *
     * @Route("/{id}/edit", name="backend_maestros_roles_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('ErosBackendBundle:MstRolesEmpresa')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MstRolesEmpresa entity.');
        }

        $editForm = $this->createForm(new MstRolesEmpresaType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing MstRolesEmpresa entity.
     *
     * @Route("/{id}/update", name="backend_maestros_roles_update")
     * @Method("post")
     * @Template("ErosBackendBundle:MstRolesEmpresa:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('ErosBackendBundle:MstRolesEmpresa')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MstRolesEmpresa entity.');
        }

        $editForm   = $this->createForm(new MstRolesEmpresaType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('backend_maestros_roles_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a MstRolesEmpresa entity.
     *
     * @Route("/{id}/delete", name="backend_maestros_roles_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('ErosBackendBundle:MstRolesEmpresa')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find MstRolesEmpresa entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('backend_maestros_roles'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
