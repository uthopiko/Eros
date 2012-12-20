<?php

namespace Eros\ExtranetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Eros\ExtranetBundle\Entity\TarifaRepository")
 * @ORM\Table (name="Tarifas")
 */
class Tarifa
{
    /**
     * @ORM\Id
     * @ORM\Column(name="PidTarifa",type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="Tarifa",type="string",length=100)
     */
    private $tarifa;
    
    /**
     * @ORM\Column(name="LimiteMenor",type="integer")
     */
    private $limitemenor;

    /**
     * @ORM\Column(name="LimiteMayor",type="integer")
     */
    private $limitemayor;

    /**
     * @ORM\Column(name="Descuento",type="integer")
     */
    private $descuento;

    /**
    * @ORM\ManyToOne(targetEntity="\Eros\FrontendBundle\Entity\Empresas")
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
     * Set tarifa
     *
     * @param string $tarifa
     */
    public function setTarifa($tarifa)
    {
        $this->tarifa = $tarifa;
    }

    /**
     * Get tarifa
     *
     * @return string 
     */
    public function getTarifa()
    {
        return $this->tarifa;
    }

    /**
     * Set limitemenor
     *
     * @param integer $limitemenor
     */
    public function setLimitemenor($limitemenor)
    {
        $this->limitemenor = $limitemenor;
    }

    /**
     * Get limitemenor
     *
     * @return integer 
     */
    public function getLimitemenor()
    {
        return $this->limitemenor;
    }

    /**
     * Set limitemayor
     *
     * @param integer $limitemayor
     */
    public function setLimitemayor($limitemayor)
    {
        $this->limitemayor = $limitemayor;
    }

    /**
     * Get limitemayor
     *
     * @return integer 
     */
    public function getLimitemayor()
    {
        return $this->limitemayor;
    }

    /**
     * Set descuento
     *
     * @param integer $descuento
     */
    public function setDescuento($descuento)
    {
        $this->descuento = $descuento;
    }

    /**
     * Get descuento
     *
     * @return integer 
     */
    public function getDescuento()
    {
        return $this->descuento;
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