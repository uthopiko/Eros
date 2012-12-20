<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eros\FrontendBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class RegisterBussinessFormType extends AbstractType
{
    private $class;

    /**
     * @param string $class The User class name
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('nombrecomercial')
            ->add('username')
            ->add('email', 'email')
            ->add('password', 'repeated', array('type' => 'password'))
            ->add('localidad')
            ->add('direccion')
            ->add('telefono')
            ->add('roles','entity',array('class' => 'ErosBackendBundle:MstRoles',
                                         'property'=>'nombre',
                                         'multiple'=>true))
            ->add('cp');
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Eros\FrontendBundle\Form\Model\RegisterBussiness',
            'intention'  => 'profile',
        );
    }

    public function getName()
    {
        return 'register_bussiness';
    }
}
