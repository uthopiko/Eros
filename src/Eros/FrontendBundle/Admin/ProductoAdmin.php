<?php
// src/Eros/BackendBundle/Admin/BackendAdmin.php
namespace Eros\FrontendBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;


class ProductoAdmin extends Admin
{
	protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
                ->add('nombre')
                ->add('descripcion')
                ->add('rutaimagen')
                /*->add('categoria', 'sonata_type_collection', array('by_reference' => false, ), array(
                'edit' => 'inline',
                'inline' => 'table',
                'sortable'  => 'position'))*/
                ->add('subcategoria','entity',array('class' => 'ErosFrontendBundle:SubCategory', 
                      'empty_value' =>  'Selecciona una subcategoria', 'required' => false,'property' => 'subcategoria'))
            ->end();
        ;
    }


	protected function configureListFields(ListMapper $mapper)
	{
		$mapper
		->add('id')
		->addIdentifier('nombre', null, array('label' => 'Producto'))
		->add('descripcion');
	}

	protected function configureDatagridFilters(DatagridMapper $mapper)
	{
		$mapper
		->add('nombre');
	}
}

?>