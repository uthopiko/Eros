<?php

namespace Eros\ExtranetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class NavegacionController extends Controller
{
      /**
     * @Route("/menulateral",name="_ajax_menu_lateral")
     */
    public function menulateralAction()
    {
        if ($_POST) {
            $id = $_POST["id"];
        }
        return $this->render('ErosExtranetBundle:Navegacion:include/menu'.$id.'.html.twig');
    }
}
