<?php
// src/Eros/BackendBundle/Admin/BackendAdmin.php
namespace Eros\BackendBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;


class EstadoPromocionAdmin extends Admin
{
	protected function configureListFields(ListMapper $mapper)
	{
		$mapper
		->addIdentifier('estado', null, array('label' => 'Estado Promoción'))
		->add('codigo');
	}

	protected function configureDatagridFilters(DatagridMapper $mapper)
	{
		$mapper
		->add('estado');
	}

	protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
                ->add('estado')
                ->add('codigo')
            ->end()
        ;
    }
}

?>