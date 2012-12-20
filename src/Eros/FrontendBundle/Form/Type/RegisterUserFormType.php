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

class RegisterUserFormType extends AbstractType
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
            ->add('username')
            ->add('email', 'email')
            ->add('password', 'repeated', array('type' => 'password'))
            ->add('localidad')
            ->add('direccion')
            ->add('provincia','entity',array(
            									'class' => 'ErosFrontendBundle:MstProvincia',
												'empty_value' =>  'Selecciona una provincia',
												'required' => true,
												'property' => 'provincia'))
            ->add('cp')
            ->add('country');
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Eros\FrontendBundle\Form\Model\RegisterUser',
            'intention'  => 'profile',
        );
    }

    public function getName()
    {
        return 'register_user';
    }
}
