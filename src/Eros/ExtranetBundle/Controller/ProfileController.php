<?php

namespace Eros\ExtranetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;
use Eros\ExtranetBundle\Form\Model\ExtranetCheckPassword;

class ProfileController extends Controller
{
     /**
     * @Route("/edit_Ajax",name="_profile_edit_ajax")
     * @Template()
     */
    public function editAjaxAction()
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $form = $this->container->get('extranet.profile.form');
        $formHandler = $this->container->get('extranet.profile.form.handler.default');
        $process = $formHandler->process($user,$em);
        if ($process) {
            //return new RedirectResponse($this->container->get('router')->generate('_profile_edit'));
        }

        return array('form' => $form->createView(), 'theme' => $this->container->getParameter('fos_user.template.theme'));
    }

     /**
     * @Route("/edit",name="_profile_edit")
     * @Template()
     */
    public function editAction()
    {
        
        $em = $this->get('doctrine.orm.entity_manager');
        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        
        $form = $this->container->get('extranet.profile.form');
        $formHandler = $this->container->get('extranet.profile.form.handler.default');
        $process = $formHandler->process($user,$em);
        if ($process) {
            return new RedirectResponse($this->container->get('router')->generate('_profile_edit'));
        }

        return array('form' => $form->createView(), 'theme' => $this->container->getParameter('fos_user.template.theme'));
    }

    /**
     * @Route("/notificaciones",name="_notificaciones")
     * @Template()
     */
    public function notificacionesAction()
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $user = $this->get('security.context')->getToken()->getUser();
        $userid = $user->GetId();
        $empresa_user = $em->getRepository('Eros\FrontendBundle\Entity\Empresas')->findEmpresaByUser($userid);

        $nItemsPendientes =  $em->getRepository('Eros\CartBundle\Entity\UsrPedidos')->CountPedidosByEmpresaEstado(2,$empresa_user->GetId());

        $nItemsPagados =  $em->getRepository('Eros\CartBundle\Entity\UsrPedidos')->CountPedidosByEmpresaEstado(3,$empresa_user->GetId());

        $nPedidosPendientesResponder =  $em->getRepository('Eros\ExtranetBundle\Entity\EmpresaPedido')->CountPedidosByCodigoEstado(7,$empresa_user->GetId());

        $nPedidosPendientesCliente =  $em->getRepository('Eros\ExtranetBundle\Entity\EmpresaPedido')->CountPedidosByCodigoEstado(6,$empresa_user->GetId());

        $nPedidosPendientesRecibidos =  $em->getRepository('Eros\ExtranetBundle\Entity\EmpresaPedido')->CountPedidosRecibidosByCodigoEstado(7,$empresa_user->GetId());

        $nPedidosPendientesProveedorRecibidos =  $em->getRepository('Eros\ExtranetBundle\Entity\EmpresaPedido')->CountPedidosRecibidosByCodigoEstado(6,$empresa_user->GetId());


        return array('ItemsPendientes' => $nItemsPendientes,'ItemsPagados'=>$nItemsPagados,'PedidosPendientesResponder'=>$nPedidosPendientesResponder,'PedidosPendienteCliente'=>$nPedidosPendientesCliente,'PedidosPendientesRecibidos'=>$nPedidosPendientesRecibidos,'PedidosPendienteProveedorRecibidos'=>$nPedidosPendientesProveedorRecibidos);
    }

}
