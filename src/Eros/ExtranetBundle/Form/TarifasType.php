<?php

namespace Eros\ExtranetBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class TarifasType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('tarifa')
            ->add('limitemenor')
            ->add('limitemayor')
            ->add('descuento')
            ->add('empresa')
        ;
    }

    public function getName()
    {
        return 'eros_extranetbundle_tarifastype';
    }
}
