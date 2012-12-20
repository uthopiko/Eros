<?php
namespace Eros\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends Controller
{
    public function indexAction()
    {
        return $this->render('ErosFrontendBundle:Profile:index.html.twig');
    }


    /**
     * @Route("/register",name="_profile_register")
     * @Template()
    */
    public function registerAction()
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $user = new \Eros\FrontendBundle\Entity\User();
        $request = $this->get('request');
        $form = $this->container->get('frontend.register.bussiness.form');
        if ('POST' === $request->getMethod()) {
        	$formHandler = $this->container->get('frontend.register.bussiness.form.handler.default');
	        $process = $formHandler->process($user,$em);
	        if ($process) {
	            $jsonResults = json_encode(array('statusCode'=>0));
	     
	    		$response = new Response($jsonResults);
	    		$response->headers->set('content-type', 'application/json');
	    
	        	return $response;
	        }
	        else {
	        	$jsonResults = json_encode(array('statusCode'=>5));
	     
	    		$response = new Response($jsonResults);
	    		$response->headers->set('content-type', 'application/json');
	    
	        	return $response;
	        }
	    }
        
        return array('form' => $form->createView(), 'theme' => $this->container->getParameter('fos_user.template.theme'));
    }


    /**
     * @Route("/register/user",name="_profile_register_user")
     * @Template()
    */
    public function registerUserAction()
    {
        $em = $this->get('doctrine.orm.entity_manager');
       
        $user = new \Eros\FrontendBundle\Entity\User();
        $request = $this->get('request');
        $form = $this->container->get('frontend.register.user.form');
        if ('POST' === $request->getMethod()) {
         	$formHandler = $this->container->get('frontend.register.user.form.handler.default');
	        $process = $formHandler->process($user,$em);

	        if ($process) {
	            $jsonResults = json_encode(array('statusCode'=>0));
	     
	    		$response = new Response($jsonResults);
	    		$response->headers->set('content-type', 'application/json');
	    
	        	return $response;
	        }
	        else {
	        	$jsonResults = json_encode(array('statusCode'=>5));
	     
	    		$response = new Response($jsonResults);
	    		$response->headers->set('content-type', 'application/json');
	    
	        	return $response;
	        }
	    }
	        
        return array('form' => $form->createView(), 'theme' => $this->container->getParameter('fos_user.template.theme'));
    }
}