<?php
namespace Eros\ExtranetBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PromocionType extends AbstractType
{
	private $id;

	public function __construct($id)
    {
        $this->id = $id;
    }

	public function buildForm(FormBuilder $builder, array $options)
	{
		$id = $this->id;
		$builder->add('Nombre', 'text',array('required'=>false,'attr'=> array('class'=>'first')));
		$builder->add('Descripcion', 'text',array('required'=>false,'attr'=> array('class'=>'first')));
		$builder->add('Descuento', 'text',array('required'=>false,'attr'=> array('class'=>'first')));
		$builder->add('FechaInicio', 'text',array('required'=>false,'attr'=> array('class'=>'calendar second')));
		$builder->add('FechaFin', 'text',array('required'=>false,'attr'=> array('class'=>'calendar second')));
		$builder->add('TipoPromocion', 'choice',  array('required'=>false,'choices'   => array(
		'1'   => 'General',
		'2'   => 'Articulos')));
		$builder->add('TipoDescuento', 'entity',  array('required'=>false,'class' => 'ErosBackendBundle:MstTipoDescuento','attr' => array('class'=>'second','style' => 'display:none'),'property' => 'Descuento'));
		$builder->add('TipoDescuento2', 'entity',  array('required'=>false,'class' => 'ErosBackendBundle:MstTipoDescuento','property' => 'Descuento','property_path' => false));
		$builder->add('EstadoPromocion', 'entity',  array('class' => 'ErosBackendBundle:MstEstadosPromocion','attr' => array('class'=>'second','style' => 'display:block'),'property' => 'Estado'));
		$builder->add('ddlArticulo','entity',
			   array('required'=>false,'class' => 'ErosFrontendBundle:Article','property_path' => false, 
					 'query_builder' => function ($repository) use ($id) {
									 $qb = $repository->createQueryBuilder('ErosFrontendBundle:Article');
									 $qb->add('where', 'ErosFrontendBundle:Article.empresa = :empresa');
									 $qb->setParameter('empresa',$id);
									return $qb;
					 },'required' => true,'property' => 'Nombre'));

	}

	public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Eros\FrontendBundle\Entity\CliPromociones',
            'intention'  => 'promociones',
        );
    }
	
	public function getName()
	{
		return 'PromocionType';
	}
}
