<?php
namespace Eros\ExtranetBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class TarifasForm extends AbstractType
{
	
	public function buildForm(FormBuilder $builder, array $options)
	{
		 $builder
            ->add('tarifa','text')
            ->add('limitemenor','text')
            ->add('limitemayor','text')
            ->add('descuento','text')
            ->add('empresa','hidden');
	}
	
	public function getName()
	{
		return 'TarifasForm';
	}
}
