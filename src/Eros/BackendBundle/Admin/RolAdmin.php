<?php
// src/Eros/BackendBundle/Admin/RolAdmin.php
namespace Eros\BackendBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;


class RolAdmin extends Admin
{
	protected function configureListFields(ListMapper $mapper)
	{
		$mapper
		->addIdentifier('rol', null, array('label' => 'Rol'))
		->add('nombre', null, array('label' => 'Nombre'))
		->add('descripcion', null, array('label' => 'Descripcion'))
		->add('codigo');
	}

	protected function configureDatagridFilters(DatagridMapper $mapper)
	{
		$mapper
		->add('rol')
		->add('nombre');
	}


	protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
                ->add('rol')
                ->add('nombre')
                ->add('descripcion')
                ->add('codigo')
            ->end();
    }
}
