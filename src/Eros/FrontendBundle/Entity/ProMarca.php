<?php

namespace Eros\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table (name="PRO_Marca")
 */
class ProMarca
{
    /**
     * @ORM\Id
     * @ORM\Column(name="PidMarca",type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $pidmarca;
    
    /**
     * @ORM\Column(name="Marca",type="string",nullable=false)
     */
    private $marca;

    /**
     * @ORM\ManyToOne(targetEntity="Empresas")
     * @ORM\JoinColumn(name="SidEmpresa", referencedColumnName="PidEmpresa",nullable="true")
     */
    private $empresa;


    /**
     * Get pidmarca
     *
     * @return integer 
     */
    public function getPidmarca()
    {
        return $this->pidmarca;
    }

    /**
     * Set marca
     *
     * @param string $marca
     */
    public function setMarca($marca)
    {
        $this->marca = $marca;
    }

    /**
     * Get marca
     *
     * @return string 
     */
    public function getMarca()
    {
        return $this->marca;
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