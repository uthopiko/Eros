<?php

namespace Eros\ExtranetBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PedidoType extends AbstractType
{
    public $id;
    public $projectChoices = array();

    public function buildForm(FormBuilder $builder, array $options)
    {
        
        /*$projectChoices[0] = "Tarifa";
        $projectChoices[1] = "Tarifa 1";*/
   
        $id = $options['data']['attr']['id'];
        $builder
            ->add('precio','text',array('property_path' => false,'attr' => array('disabled' => 'true')))
            ->add('estadopedido', 'entity', 
          array('class' => 'ErosBackendBundle:MstEstadoPedido','attr' => array('disabled' => 'true'),'empty_value' => 
'Selecciona un dato', 'required' => false,'property' => 'estadopedido','property_path' => false,'query_builder' => function ($repository) {
                                     $qb = $repository->createQueryBuilder('ErosBackendBundle:MstEstadoPedido');
                                     $qb->add('where', 'ErosBackendBundle:MstEstadoPedido.tipopedido = \'Extranet\'');
                                    return $qb;}))
            ->add('tarifa', 'entity', 
          array('class' => 'ErosExtranetBundle:Tarifa', 'empty_value' => 
'Selecciona un dato', 'attr' => array('disabled' => 'true'),'required' => false,'property' => 'tarifa','property_path' => false,'query_builder' => function ($repository) use ($id){
                                     $qb = $repository->createQueryBuilder('ErosExtranetBundle:Tarifa');
                                     $qb->add('where', 'ErosExtranetBundle:Tarifa.empresa = :empresa');
                                     $qb->setParameter('empresa',$id);
                                    return $qb;}))
             /*->add('project', 
              'choice',
               array('choices' => $projectChoices,
                     'required' => false))*/;
    }

    public function getName()
    {
        return 'eros_extranetbundle_pedidotype';
    }
}
