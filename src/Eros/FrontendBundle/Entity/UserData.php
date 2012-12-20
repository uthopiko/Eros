<?php
// src\Eros\FrontendBundle\Entity/User.php

namespace Eros\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_userdata")
 */
class UserData
{
    /**
     * @ORM\Id
     * @ORM\Column(name="PidUserData",type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $piduserdata;

	
   /**
     * @ORM\ManyToOne(targetEntity="MstProvincia")
     * @ORM\JoinColumn(name="SidProvincia", referencedColumnName="PidProvincia")
     */
    protected $provincia;
    
	
    /**
    * @ORM\Column(name="Direccion",type="string",length=100,nullable=false)
    */
    private $direccion;

    /**
     * @ORM\Column(name="Cp",type="string",length=5,nullable=false)
     */
    private $cp;

    /**
     * @ORM\Column(name="Telefono",type="string",length=20,nullable=false)
     */
    private $telefono;

   /**
     * @ORM\Column(name="Localidad",type="string",length=100,nullable=false)
     */
    private $localidad;


	/**
     * @ORM\Column(name="country",type="string",length=100,nullable=false)
     */
    private $country;

    /**
     * Get piduserdata
     *
     * @return integer 
     */
    public function getPiduserdata()
    {
        return $this->piduserdata;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    }

    /**
     * Get direccion
     *
     * @return string 
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set cp
     *
     * @param string $cp
     */
    public function setCp($cp)
    {
        $this->cp = $cp;
    }

    /**
     * Get cp
     *
     * @return string 
     */
    public function getCp()
    {
        return $this->cp;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }

    /**
     * Get telefono
     *
     * @return string 
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set localidad
     *
     * @param string $localidad
     */
    public function setLocalidad($localidad)
    {
        $this->localidad = $localidad;
    }

    /**
     * Get localidad
     *
     * @return string 
     */
    public function getLocalidad()
    {
        return $this->localidad;
    }

    /**
     * Set country
     *
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set provincia
     *
     * @param Eros\FrontendBundle\Entity\MstProvincia $provincia
     */
    public function setProvincia(\Eros\FrontendBundle\Entity\MstProvincia $provincia)
    {
        $this->provincia = $provincia;
    }

    /**
     * Get provincia
     *
     * @return Eros\FrontendBundle\Entity\MstProvincia 
     */
    public function getProvincia()
    {
        return $this->provincia;
    }
}