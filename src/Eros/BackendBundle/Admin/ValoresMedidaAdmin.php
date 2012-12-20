<?php
// src/Eros/BackendBundle/Admin/BackendAdmin.php
namespace Eros\BackendBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;


class ValoresMedidaAdmin extends Admin
{
	protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
                ->add('valor')
                /*->add('categoria', 'sonata_type_collection', array('by_reference' => false, ), array(
                'edit' => 'inline',
                'inline' => 'table',
                'sortable'  => 'position'))*/
                ->add('unidadmedida','entity',array('class' => 'ErosBackendBundle:MstUnidadMedida', 
                      'empty_value' =>  'Selecciona una unidad medida', 'required' => true,'property' => 'unidadmedida'))
                ->add('general')
            ->end();
    }

	protected function configureListFields(ListMapper $mapper)
	{
		$mapper
		->add('id')
		->addIdentifier('valor', null, array('label' => 'Sub-Categoria'))
		->add('unidadmedida')
		->add('general');
	}

	protected function configureDatagridFilters(DatagridMapper $mapper)
	{
		$mapper
		->add('valor');
	}
}

?>