<?php

namespace Eros\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table (name="MST_UnidadesMedida")
 */
class MstUnidadMedida
{
    /**
     * @ORM\Id
     * @ORM\Column(name="PidUnidadMedida",type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="UnidadMedida",type="string",length=100)
     */
    private $unidadmedida;
    
    /**
     * @ORM\Column(name="Codigo",type="string",length=15)
     */
    private $codigo;

    /**
	 * @ORM\ManyToOne(targetEntity="\Eros\FrontendBundle\Entity\Empresas")
	 * @ORM\JoinColumn(name="SidEmpresa", referencedColumnName="PidEmpresa",nullable=true)
	 */
    private $empresa;

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
     * Set unidadmedida
     *
     * @param string $unidadmedida
     */
    public function setUnidadmedida($unidadmedida)
    {
        $this->unidadmedida = $unidadmedida;
    }

    /**
     * Get unidadmedida
     *
     * @return string 
     */
    public function getUnidadmedida()
    {
        return $this->unidadmedida;
    }

    /**
     * Set codigo
     *
     * @param string $codigo
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    /**
     * Get codigo
     *
     * @return string 
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    public function __toString()
    {
        return $this->unidadmedida;
    }

    /**
     * Set empresa
     *
     * @param Eros\FrontendBundle\Entity\Empresas $empresa
     */
    public function setEmpresa(\Eros\FrontendBundle\Entity\Empresas $empresa)
    {
        $this->empresa = $empresa;
    }

    /**
     * Get empresa
     *
     * @return Eros\FrontendBundle\Entity\Empresas 
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }
}