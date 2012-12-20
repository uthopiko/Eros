<?php
// src/Eros/BackendBundle/Admin/BackendAdmin.php
namespace Eros\BackendBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;


class EstadoPedidoAdmin extends Admin
{
	protected function configureListFields(ListMapper $mapper)
	{
		$mapper
		->add('id')
		->addIdentifier('estadopedido', null, array('label' => 'Estado Pedido'))
		->add('codigo');
	}

	protected function configureDatagridFilters(DatagridMapper $mapper)
	{
		$mapper
		->add('estadopedido');
	}

	protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
                ->add('estadopedido')
                ->add('codigo')
            ->end();
    }
}
