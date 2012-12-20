<?php
// src/Eros/BackendBundle/Admin/BackendAdmin.php
namespace Eros\BackendBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;


class UnidadMedidaAdmin extends Admin
{
	protected function configureListFields(ListMapper $mapper)
	{
		$mapper
		->add('id')
		->addIdentifier('unidadmedida', null, array('label' => 'Unidad Medida'))
		->add('codigo');
	}

	protected function configureDatagridFilters(DatagridMapper $mapper)
	{
		$mapper
		->add('unidadmedida');
	}

	protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
                ->add('unidadmedida')
                ->add('codigo')
                ->add('empresa','entity',array('class' => 'ErosFrontendBundle:Empresas', 
                      'empty_value' =>  'Selecciona una Empresa', 'required' => false,'property' => 'nombrecomercial'))
            ->end()
        ;
    }
}

?>