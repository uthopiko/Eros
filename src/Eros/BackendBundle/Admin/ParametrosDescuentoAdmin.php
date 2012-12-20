<?php
// src/Eros/BackendBundle/Admin/BackendAdmin.php
namespace Eros\BackendBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;


class ParametrosDescuentoAdmin extends Admin
{
	protected function configureListFields(ListMapper $mapper)
	{
		$mapper
		->add('id')
		->addIdentifier('parametro', null, array('label' => 'Parametro'));
	}

	protected function configureDatagridFilters(DatagridMapper $mapper)
	{
		$mapper
		->add('parametro');
	}

	protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
                ->add('parametro')
                ->add('sidtipodescuento','entity',array('class' => 'ErosBackendBundle:MstTipoDescuento', 
                      'empty_value' =>  'Seleccione tipo descuento', 'required' => true,'property' => 'descuento'))
            ->end()
        ;
    }
}

?>