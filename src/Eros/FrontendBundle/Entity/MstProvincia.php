<?php

namespace Eros\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table (name="MST_Provincia")
 */
class MstProvincia
{
    /**
     * @ORM\Id
     * @ORM\Column(name="PidProvincia",type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $pidprovincia;

    /**
     * @ORM\Column(name="Provincia",type="string",length=100)
     */
    private $provincia;

	/**
	 * @ORM\ManyToOne(targetEntity="MstComunidadAutonoma")
	 * @ORM\JoinColumn(name="SidComunidadAutonoma", referencedColumnName="PidComunidadAutonoma")
	 */
    private $SidComunidadAutonoma;
    
    /**
     * @ORM\Column(name="Codigo",type="string",length=2)
     */
    private $Codigo;

    /**
     * Get pidprovincia
     *
     * @return integer 
     */
    public function getPidprovincia()
    {
        return $this->pidprovincia;
    }

    /**
     * Set provincia
     *
     * @param string $provincia
     */
    public function setProvincia($provincia)
    {
        $this->provincia = $provincia;
    }

    /**
     * Get provincia
     *
     * @return string 
     */
    public function getProvincia()
    {
        return $this->provincia;
    }

    /**
     * Set Codigo
     *
     * @param string $codigo
     */
    public function setCodigo($codigo)
    {
        $this->Codigo = $codigo;
    }

    /**
     * Get Codigo
     *
     * @return string 
     */
    public function getCodigo()
    {
        return $this->Codigo;
    }

    /**
     * Set SidComunidadAutonoma
     *
     * @param Eros\FrontendBundle\Entity\MstComunidadAutonoma $sidComunidadAutonoma
     */
    public function setSidComunidadAutonoma(\Eros\FrontendBundle\Entity\MstComunidadAutonoma $sidComunidadAutonoma)
    {
        $this->SidComunidadAutonoma = $sidComunidadAutonoma;
    }

    /**
     * Get SidComunidadAutonoma
     *
     * @return Eros\FrontendBundle\Entity\MstComunidadAutonoma 
     */
    public function getSidComunidadAutonoma()
    {
        return $this->SidComunidadAutonoma;
    }
}