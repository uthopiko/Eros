<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eros\ExtranetBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ExtranetProfileFormType extends AbstractType
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
        $child = $builder->create('user', 'form', array('data_class' => $this->class));
        $this->buildUserForm($child, $options);

        $builder
            ->add('nombrecomercial')
            ->add($child)
            ->add('current', 'password')
            ->add('localidad')
            ->add('direccion')
            ->add('telefono')
            ->add('cp');
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Eros\ExtranetBundle\Form\Model\ExtranetCheckPassword',
            'intention'  => 'profile',
        );
    }

    public function getName()
    {
        return 'extranet_profile';
    }

    /**
     * Builds the embedded form representing the user.
     *
     * @param FormBuilder $builder
     * @param array       $options
     */
    protected function buildUserForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('email', 'email')
        ;
    }
}
