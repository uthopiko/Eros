<?php

namespace Eros\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/value/{entity}/{param}/{value}",name="_get_value_param",options={"expose"=true})
     * @Template()
     */
    public function indexAction($entity,$param,$value)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $function = "findBy".$param;
		$results = $em->getRepository($entity)->{$function}($value);
		
		$arrResults = array('statusCode'=>0);
		foreach ($results as $res) {
			$arrResults ['result'][] = $this->get("eros.utilidades")->entityToArray($res);
		}
		
		$jsonResults = json_encode($arrResults);

		$response = new Response($jsonResults);
		$response->headers->set('content-type', 'application/json');

        return $response;
    }
}
