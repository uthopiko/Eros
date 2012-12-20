<?php
// src/Eros/BackendBundle/Admin/BackendAdmin.php
namespace Eros\FrontendBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;


class CategoriaAdmin extends Admin
{
	protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
                ->add('categoria')
            ->end()
        ;
    }


	protected function configureListFields(ListMapper $mapper)
	{
		$mapper
		->add('pidcategoria')
		->addIdentifier('categoria', null, array('label' => 'Categoria'))
		->add('codigo');
	}

	protected function configureDatagridFilters(DatagridMapper $mapper)
	{
		$mapper
		->add('categoria');
	}
}

?>