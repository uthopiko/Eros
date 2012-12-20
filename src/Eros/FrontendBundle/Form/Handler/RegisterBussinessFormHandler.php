<?php
namespace Eros\FrontendBundle\Form\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Eros\FrontendBundle\Form\Model\RegisterBussiness;
use FOS\UserBundle\Form\Model\CheckPassword;
use Doctrine\ORM\EntityManager;
use Eros\FrontendBundle\Entity\User;
use Eros\FrontendBundle\Entity\Empresas;

class RegisterBussinessFormHandler
{
    protected $request;
    protected $userManager;
    protected $form;
	protected $fb;

    public function __construct(Form $form, Request $request, UserManagerInterface $userManager,$firePhp)
    {
        $this->form = $form;
        $this->request = $request;
        $this->userManager = $userManager;
        $this->fb = $firePhp;
    }


    public function process(UserInterface $user,EntityManager $em)
    {
        $user = new \Eros\FrontendBundle\Entity\User();
        $this->form->setData(new RegisterBussiness($user));
        if ('POST' === $this->request->getMethod()) {
            $this->form->bindRequest($this->request);
            if ($this->form->isValid()) {
                if ($this->request->isXmlHttpRequest()) { 
                    $user->setEnabled(true);
                    $userdata = new \Eros\FrontendBundle\Entity\UserData();
                    $empresa = new \Eros\FrontendBundle\Entity\Empresas();
                    $array_key_form = $this->request->get("frontend_register_bussiness");
                    foreach ($array_key_form as $key=>$value){             
                        if($key=="password"){
                            $pass = $array_key_form[$key];
                            $user->setPlainPassword($pass['first']);
                        }else if($key=="username"){
                            $user->setUsername($array_key_form[$key]);
                        }else if($key=="nombrecomercial"){
                            $empresa->setNombrecomercial($array_key_form[$key]);
                        }else if($key=="localidad" || $key=="cp" || $key=="direccion" || $key=="telefono" || $key=="nombrecomercial"){
                            $userdata->{'set'.ucfirst($key)}( $array_key_form[$key]);
                        }else if($key=="roles"){
                            $array_key_form[$key][] = 'ROLE_BUSSINESS';
                            $user->{'set'.ucfirst($key)}( $array_key_form[$key] );
                        }else if($key != '_token'){
                            $user->{'set'.ucfirst($key)}( $array_key_form[$key] );
                        }       
                        $em->persist($userdata);
                        $user->setUserData($userdata);
                    }
                $this->onSuccess($user, $empresa, $em);

                return true;
            }
            // Reloads the user to reset its username. This is needed when the
            // username or password have been changed to avoid issues with the
            // security layer.
           
        }

    }

        return false;
    }


    protected function onSuccess(UserInterface $user, \Eros\FrontendBundle\Entity\Empresas $empresa,EntityManager $em)
    {
        $model = new RegisterBussiness($user);

        $this->userManager->updateCanonicalFields($user);
        $this->userManager->updatePassword($user);
       
        $model->updateUser($em,$user);

        $empresa->setUsuario($user);
        $em->persist($empresa);
        $em->flush();
    }
}
