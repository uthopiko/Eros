<?php
namespace Eros\ExtranetBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PromocionesForm extends AbstractType
{
	
	public function buildForm(FormBuilder $builder, array $options)
	{
		$id = $options['attr']['id'];

		$builder->add('Nombre', 'text',array('attr'=> array('class'=>'first')));
		$builder->add('Descripcion', 'text',array('attr'=> array('class'=>'first')));
		$builder->add('Descuento', 'text',array('attr'=> array('class'=>'first','style' => 'display:block')));
		$builder->add('FechaInicio', 'text',array('required'=>false,'attr'=> array('class'=>'calendar second')));
		$builder->add('FechaFin', 'text',array('required'=>false,'attr'=> array('class'=>'calendar second')));
		$builder->add('TipoPromocion', 'choice',  array('choices'   => array(
		'1'   => 'General',
		'2'   => 'Articulos')));
		$builder->add('EstadoPromocion', 'entity',  array('class' => 'ErosBackendBundle:MstEstadosPromocion','attr' => array('class'=>'second','style' => 'display:block'),'property' => 'Estado'));
		$builder->add('TipoDescuento', 'entity',  array('class' => 'ErosBackendBundle:MstTipoDescuento','attr' => array('class'=>'second','style' => 'display:block'),'property' => 'Descuento'));
		$builder->add('TipoDescuento2', 'entity',  array('class' => 'ErosBackendBundle:MstTipoDescuento','property' => 'Descuento','property_path' => false));
		$builder->add('ddlArticulo','entity',
			   array('class' => 'ErosFrontendBundle:Article','property_path' => false, 
					 'query_builder' => function ($repository) use ($id) {
									 $qb = $repository->createQueryBuilder('ErosFrontendBundle:Article');
									 $qb->add('where', 'ErosFrontendBundle:Article.empresa = :empresa');
									 $qb->setParameter('empresa',$id);
									return $qb;
					 },'required' => true,'property' => 'Nombre'));

	}
	
	public function getName()
	{
		return 'PromocionesForm';
	}
}
