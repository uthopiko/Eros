<?php
// src/Eros/BackendBundle/Admin/BackendAdmin.php
namespace Eros\BackendBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;


class TipoDescuentoAdmin extends Admin
{
	protected function configureListFields(ListMapper $mapper)
	{
		$mapper
		->add('id')
		->addIdentifier('descuento', null, array('label' => 'Estado Pedido'))
		->add('codigo');
	}

	protected function configureDatagridFilters(DatagridMapper $mapper)
	{
		$mapper
		->add('descuento');
	}

	protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
                ->add('descuento')
                ->add('codigo')
            ->end()
        ;
    }
}

?>