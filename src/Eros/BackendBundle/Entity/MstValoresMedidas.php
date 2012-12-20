<?php

namespace Eros\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table (name="MST_ValoresMedidas")
 */
class MstValoresMedidas
{
    /**
     * @ORM\Id
     * @ORM\Column(name="PidValorMedida",type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="Valor",type="string",length=100)
     */
    private $valor;
    
    /**
    * @ORM\ManyToOne(targetEntity="\Eros\BackendBundle\Entity\MstUnidadMedida")
    * @ORM\JoinColumn(name="SidUnidadMedida", referencedColumnName="PidUnidadMedida")
    */
    private $unidadmedida;

    /**
     * @ORM\Column(name="General",type="boolean",nullable=false)
     */
    private $general;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set valor
     *
     * @param string $valor
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
    }

    /**
     * Get valor
     *
     * @return string 
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set general
     *
     * @param boolean $general
     */
    public function setGeneral($general)
    {
        $this->general = $general;
    }

    /**
     * Get general
     *
     * @return boolean 
     */
    public function getGeneral()
    {
        return $this->general;
    }

    /**
     * Set unidadmedida
     *
     * @param Eros\BackendBundle\Entity\MstUnidadMedida $unidadmedida
     */
    public function setUnidadmedida(\Eros\BackendBundle\Entity\MstUnidadMedida $unidadmedida)
    {
        $this->unidadmedida = $unidadmedida;
    }

    /**
     * Get unidadmedida
     *
     * @return Eros\BackendBundle\Entity\MstUnidadMedida 
     */
    public function getUnidadmedida()
    {
        return $this->unidadmedida;
    }

    
}