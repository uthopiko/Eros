<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eros\FrontendBundle\Form\Model;

use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Form\Model\CheckPassword;
use Eros\FrontendBundle\Entity\User;
use Doctrine\ORM\EntityManager;

class RegisterBussiness
{
	public function __construct(User $user){

	}
    
    /*
     * @var string
    */
    public $username;

    /*
     * @var string
    */
    public $password;

    /*
     * @var string
    */
    public $email;

	/*
     * @var string
    */
    public $nombrecomercial;


    /*
     * @var string
    */
    public $direccion;

    /*
     * @var string
    */
    public $cp;

    /*
     * @var string
    */
    public $localidad;

    /*
     * @var string
    */
    public $telefono;

    /*
     * @var object
    */
    public $roles;


 	protected $em;

    public function getArrayRoles()
    {
        $arrRoles = array();
        foreach ($this->roles as $rol) {
            $arrRoles [] = $rol->nombre;
        }
        return $arrRoles;
    }

    /**
     * Updates a user.
     *
     * @param UserInterface $user
     * @param Boolean       $andFlush Whether to flush the changes (default true)
     */
    public function updateUser(EntityManager $em,User $user, $andFlush = true)
    {
        $em->persist($user);
        //if ($andFlush) {
            $em->flush();
        //}
    }

}
