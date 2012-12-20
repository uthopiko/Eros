<?php

namespace Eros\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table (name="EMP_EmpresasTiposEmpresa")
 */
class EmpresaTipoEmpresa
{
    /**
     * @ORM\Id
     * @ORM\Column(name="PidEmpresaTipoEmpresa",type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="\Eros\BackendBundle\Entity\MstTipoEmpresa", inversedBy="EmpresaTipoEmpresa")
     * @ORM\JoinColumn(name="SidTipoEmpresa", referencedColumnName="PidTipoEmpresa")
     */
    private $tipoempresa;

   /**
     * @ORM\ManyToOne(targetEntity="Empresas", inversedBy="EmpresaTipoEmpresa")
     * @ORM\JoinColumn(name="SidEmpresa", referencedColumnName="PidEmpresa")
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
     * Set tipoempresa
     *
     * @param Eros\BackendBundle\Entity\MstTipoEmpresa $tipoempresa
     */
    public function setTipoempresa(\Eros\BackendBundle\Entity\MstTipoEmpresa $tipoempresa)
    {
        $this->tipoempresa = $tipoempresa;
    }

    /**
     * Get tipoempresa
     *
     * @return Eros\BackendBundle\Entity\MstTipoEmpresa 
     */
    public function getTipoempresa()
    {
        return $this->tipoempresa;
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