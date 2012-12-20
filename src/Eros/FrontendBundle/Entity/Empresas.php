<?php

namespace Eros\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Eros\FrontendBundle\Entity\EmpresasRepository")
 * @ORM\Table (name="EMP_Empresas")
 */
class Empresas
{
    /**
     * @ORM\Id
     * @ORM\Column(name="PidEmpresa",type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    
    /**
     * @ORM\Column(name="NombreComercial",type="string",nullable="false")
     */
    private $nombrecomercial;
    
    /**
     * @ORM\Column(name="NombreFiscal",type="string",nullable="false")
     */
    private $nombrefiscal;

    /**
     * @ORM\Column(name="NIF",type="string",length=10,nullable="false")
     */
    private $nif;
    
    /**
     * @ORM\Column(name="DescripcionEmpresa",type="string",nullable="true")
     */
    private $descripcionempresa;
    
    /**
     * @ORM\Column(name="Stock",type="boolean",nullable="true")
     */
    private $stock;
    
    /**
     * @ORM\Column(name="Promociones",type="boolean",nullable="true")
     */
    private $promociones;
    
    /**
     * @ORM\Column(name="Eventos",type="boolean",nullable="true")
     */
    private $eventos;
    
    /**
     * @ORM\Column(name="Logo",type="string",nullable="true")
     */
    private $logo;
    
    /**
    * @ORM\ManyToOne(targetEntity="User")
    * @ORM\JoinColumn(name="SidUsuario", referencedColumnName="PidUsuario")
    */
    private $usuario;

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
     * Set nombrecomercial
     *
     * @param string $nombrecomercial
     */
    public function setNombrecomercial($nombrecomercial)
    {
        $this->nombrecomercial = $nombrecomercial;
    }

    /**
     * Get nombrecomercial
     *
     * @return string 
     */
    public function getNombrecomercial()
    {
        return $this->nombrecomercial;
    }

    /**
     * Set nombrefiscal
     *
     * @param string $nombrefiscal
     */
    public function setNombrefiscal($nombrefiscal)
    {
        $this->nombrefiscal = $nombrefiscal;
    }

    /**
     * Get nombrefiscal
     *
     * @return string 
     */
    public function getNombrefiscal()
    {
        return $this->nombrefiscal;
    }

    /**
     * Set nif
     *
     * @param string $nif
     */
    public function setNif($nif)
    {
        $this->nif = $nif;
    }

    /**
     * Get nif
     *
     * @return string 
     */
    public function getNif()
    {
        return $this->nif;
    }

    /**
     * Set descripcionempresa
     *
     * @param string $descripcionempresa
     */
    public function setDescripcionempresa($descripcionempresa)
    {
        $this->descripcionempresa = $descripcionempresa;
    }

    /**
     * Get descripcionempresa
     *
     * @return string 
     */
    public function getDescripcionempresa()
    {
        return $this->descripcionempresa;
    }

    /**
     * Set stock
     *
     * @param boolean $stock
     */
    public function setStock($stock)
    {
        $this->stock = $stock;
    }

    /**
     * Get stock
     *
     * @return boolean 
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Set promociones
     *
     * @param boolean $promociones
     */
    public function setPromociones($promociones)
    {
        $this->promociones = $promociones;
    }

    /**
     * Get promociones
     *
     * @return boolean 
     */
    public function getPromociones()
    {
        return $this->promociones;
    }

    /**
     * Set eventos
     *
     * @param boolean $eventos
     */
    public function setEventos($eventos)
    {
        $this->eventos = $eventos;
    }

    /**
     * Get eventos
     *
     * @return boolean 
     */
    public function getEventos()
    {
        return $this->eventos;
    }

    /**
     * Set logo
     *
     * @param string $logo
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
    }

    /**
     * Get logo
     *
     * @return string 
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set usuario
     *
     * @param Eros\FrontendBundle\Entity\User $usuario
     */
    public function setUsuario(\Eros\FrontendBundle\Entity\User $usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * Get usuario
     *
     * @return Eros\FrontendBundle\Entity\User 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
}