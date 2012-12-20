<?php

namespace Eros\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class MstRolesEmpresaType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('rol')
            ->add('codigo')
            ->add('empresas')
        ;
    }

    public function getName()
    {
        return 'eros_backendbundle_mstrolesempresatype';
    }
}
