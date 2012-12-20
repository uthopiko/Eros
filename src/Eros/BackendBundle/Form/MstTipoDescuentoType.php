<?php

namespace Eros\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class MstTipoDescuentoType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('descuento')
        ;
    }

    public function getName()
    {
        return 'eros_backendbundle_msttipodescuentotype';
    }
}
