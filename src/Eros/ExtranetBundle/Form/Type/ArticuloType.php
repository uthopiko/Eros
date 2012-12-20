<?php
namespace Eros\ExtranetBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ArticuloType extends AbstractType
{
	private $util;
	private $model;

	public function __construct($model,$util) {
		$this->util = $util;
		$this->model = $model;
	}


    public function buildForm(FormBuilder $builder, array $options)
    {
    	$id = $this->util->getEmpresaId();
        $builder->add('Nombre', 'text');
        $builder->add('Precio', 'text');
        $builder->add('Medidas', 'entity', array(
        								   'class' => 'ErosBackendBundle:MstUnidadMedida',
        								   'empty_value' =>'Selecciona una unidad',
        								   'required' => false,
        								   'property' => 'unidadmedida',
        								   'query_builder' => function ($repository)  use ($id) {
                                     			$qb = $repository->createQueryBuilder('ErosBackendBundle:MstUnidadMedida');
                                     			$qb->add('where', 'ErosBackendBundle:MstUnidadMedida.empresa =:empresa OR ErosBackendBundle:MstUnidadMedida.empresa is NULL');
                                     			$qb->setParameter('empresa',$id);
                                    			return $qb;}));
        $builder->add('Stock', 'text');
        $builder->add('imagen','file',array('required'=>false));
        $builder->add('categoria', 'entity', 
          array('class' => 'ErosFrontendBundle:Category', 'empty_value' => 
'Selecciona una categoria', 'required' => false,'property' => 'categoria'));
        $builder->add('subcategoria', 'entity', 
          array('class' => 'ErosFrontendBundle:SubCategory', 'empty_value' => 
'Selecciona un dato', 'required' => false,'property' => 'subcategoria'));
        $builder->add('product', 'entity', 
          array('class' => 'ErosFrontendBundle:Product', 'empty_value' => 
'Selecciona un dato', 'required' => false,'property' => 'nombre'));
        $builder->add('PorMayor', 'checkbox',array('required'=>false));
        $builder->add('PorMenor', 'checkbox',array('required'=>false));
        $builder->add('description', 'textarea',array('required'=>false));
        $builder->add('pidarticulo', 'hidden',array('required'=>false));
        $builder->add('sidproducto','text');
    }

    public function getName()
    {
        return 'ArticuloForm';
    }
}
