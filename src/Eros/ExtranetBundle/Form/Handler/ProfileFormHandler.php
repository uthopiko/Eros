<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eros\ExtranetBundle\Form\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Eros\ExtranetBundle\Form\Model\ExtranetCheckPassword;
use FOS\UserBundle\Form\Model\CheckPassword;
use Doctrine\ORM\EntityManager;
use Eros\FrontendBundle\Entity\User;

class ProfileFormHandler
{
    protected $request;
    protected $userManager;
    protected $form;

    public function __construct(Form $form, Request $request, UserManagerInterface $userManager)
    {
        $this->form = $form;
        $this->request = $request;
        $this->userManager = $userManager;
    }

    public function process(UserInterface $user,EntityManager $em)
    {
        $this->form->setData(new ExtranetCheckPassword($user));
        if ('POST' === $this->request->getMethod()) {
            $this->form->bindRequest($this->request);
            if ($this->form->isValid()) {
                if ($this->request->isXmlHttpRequest()) { 
                    $userdata = $user->GetUserdata();
                    if(!is_object($userdata)){
                        $userdata = new \Eros\FrontendBundle\Entity\UserData();
                    }else{
                        $userdata = $em->getRepository('Eros\FrontendBundle\Entity\UserData')->find($user->GetUserdata()->getPiduserdata());
                    }
                    $extranet_array_form = $this->request->get("extranet_profile");
                    foreach ($extranet_array_form as $key=>$value){             
                        if($key=="current"){
                            $user->setPlainPassword($extranet_array_form[$key]);
                        }else if($key=="localidad" || $key=="cp" || $key=="direccion" || $key=="telefono")
                                $userdata->{'set'.ucfirst($key)}( $extranet_array_form[$key]);
                    }
                    $em->persist($userdata);
                    $user->setUserData($userdata);
                }
                $this->onSuccess($user,$em);

                return true;
            }
            // Reloads the user to reset its username. This is needed when the
            // username or password have been changed to avoid issues with the
            // security layer.
            $this->userManager->reloadUser($user);
        }

        return false;
    }


    protected function onSuccess(UserInterface $user,EntityManager $em)
    {
        $model = new ExtranetCheckPassword($user);

        $this->userManager->updateCanonicalFields($user);
        $this->userManager->updatePassword($user);
        $model->updateUser($em,$user);
    }
}
