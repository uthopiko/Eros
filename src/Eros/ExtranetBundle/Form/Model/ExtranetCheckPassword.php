<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eros\ExtranetBundle\Form\Model;

use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Form\Model\CheckPassword;
use Eros\FrontendBundle\Entity\User;
use Doctrine\ORM\EntityManager;

class ExtranetCheckPassword extends CheckPassword
{
	public function __construct(User $user){
            parent::__construct($user);
            $userdata=$user->getUserdata();
            try{
                if($userdata == null || !is_object($userdata)){
                    $error = 'No estan definidos todos los datos de los usuarios';
                    throw new \Exception($error);
                }
        		$this->direccion = $user->getUserdata()->getDireccion();
        		$this->cp = $user->getUserdata()->getCp();
        		$this->localidad = $user->getUserdata()->getLocalidad();
        		$this->current = 'admin';
        		$this->nombrecomercial = 'Nombre';
                $this->telefono = $user->getUserdata()->getTelefono();
            }catch(\Exception $e) {
            echo "<!--".$e->getMessage()."-->";
            return false;
        }
	}

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

 	protected $em;

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
