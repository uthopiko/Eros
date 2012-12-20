<?php
// src/Eros/BackendBundle/Admin/BackendAdmin.php
namespace Eros\FrontendBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;


class SubCategoriaAdmin extends Admin
{
	protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
                ->add('subcategoria')
                /*->add('categoria', 'sonata_type_collection', array('by_reference' => false, ), array(
                'edit' => 'inline',
                'inline' => 'table',
                'sortable'  => 'position'))*/
                ->add('categoria','entity',array('class' => 'ErosFrontendBundle:Category', 
                      'empty_value' =>  'Selecciona una categoria', 'required' => false,'property' => 'categoria'))
            ->end();
    }

	protected function configureListFields(ListMapper $mapper)
	{
		$mapper
		->add('id')
		->addIdentifier('subcategoria', null, array('label' => 'Sub-Categoria'));
	}

	protected function configureDatagridFilters(DatagridMapper $mapper)
	{
		$mapper
		->add('subcategoria');
	}
}

?>