<?php

namespace Eros\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


class SqlController extends Controller
{
     	/**
     	* @Route("/",name="_sql")
         * @Template()
         */
         public function sqlAction()
         {
            $request = $this->get('request');

            if ('POST' == $request->getMethod()) {
                $sql = $_POST["sql"];
             	$em=$this->get('doctrine.orm.entity_manager');
    	        $query = $em->createQuery($sql);
    	        $items = $query->getResult();
                \Doctrine\Common\Util\Debug::dump($items);
            }
	        
            return array();
         }
}

?>