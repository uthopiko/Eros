<?php

namespace Eros\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class MstEstadoPedidoType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('estadopedido')
            ->add('codigo')
        ;
    }

    public function getName()
    {
        return 'eros_backendbundle_mstestadopedidotype';
    }
}
