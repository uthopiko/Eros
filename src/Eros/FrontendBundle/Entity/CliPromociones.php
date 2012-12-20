<?php

namespace Eros\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Eros\FrontendBundle\Entity\CliPromocionesRepository")
 * @ORM\Table (name="CLI_Promociones")
 */
class CliPromociones
{
    /**
     * @ORM\Id
     * @ORM\Column(name="PidPromocion",type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    
    /**
     * @ORM\Column(name="Nombre",type="string",nullable=false)
     */
    private $nombre;
    
    /**
     * @ORM\Column(name="FechaInicio",type="string",nullable=true)
     */
    private $fechainicio;

   /**
     * @ORM\Column(name="FechaFin",type="string",nullable=true)
     */
    private $fechafin;
	
	/**
     * @ORM\Column(name="Descripcion",type="string",nullable=true)
     */
    private $descripcion;
	
	/**
     * @ORM\Column(name="Descuento",type="decimal",nullable=true)
     */
    private $descuento;
	
	/**
     * @ORM\Column(name="ImagenPromocional",type="string",nullable=true)
     */
    private $imagenpromocional;

    /**
	 * @ORM\ManyToOne(targetEntity="Empresas")
	 * @ORM\JoinColumn(name="SidEmpresa", referencedColumnName="PidEmpresa")
	 */
    private $empresa;
	
	 /**
	 * @ORM\ManyToOne(targetEntity="\Eros\BackendBundle\Entity\MstTipoDescuento")
	 * @ORM\JoinColumn(name="SidTipoDescuento", referencedColumnName="PidTipoDescuento",nullable="true")
	 */
    private $tipodescuento;
	
	 /**
     * @ORM\Column(name="TipoPromocion",type="integer",nullable=false)
     */
    private $tipopromocion;

    /**
     * @ORM\ManyToOne(targetEntity="\Eros\BackendBundle\Entity\MstEstadosPromocion")
     * @ORM\JoinColumn(name="SidEstadoPromocion", referencedColumnName="PidEstadoPromocion",nullable="false")
     */
    private $estadopromocion;
	
    /**
	* @ORM\OneToMany(targetEntity="ProPromocionArticulo", mappedBy="CliPromociones", cascade={"persist"})
	*/
    private $sidarticulopromocion;
    public function __construct()
    {
        $this->sidarticulopromocion = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
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
     * Set nombre
     *
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set fechainicio
     *
     * @param string $fechainicio
     */
    public function setFechainicio($fechainicio)
    {
        $this->fechainicio = $fechainicio;
    }

    /**
     * Get fechainicio
     *
     * @return string 
     */
    public function getFechainicio()
    {
        return $this->fechainicio;
    }

    /**
     * Set fechafin
     *
     * @param string $fechafin
     */
    public function setFechafin($fechafin)
    {
        $this->fechafin = $fechafin;
    }

    /**
     * Get fechafin
     *
     * @return string 
     */
    public function getFechafin()
    {
        return $this->fechafin;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set descuento
     *
     * @param decimal $descuento
     */
    public function setDescuento($descuento)
    {
        $this->descuento = $descuento;
    }

    /**
     * Get descuento
     *
     * @return decimal 
     */
    public function getDescuento()
    {
        return $this->descuento;
    }

    /**
     * Set imagenpromocional
     *
     * @param string $imagenpromocional
     */
    public function setImagenpromocional($imagenpromocional)
    {
        $this->imagenpromocional = $imagenpromocional;
    }

    /**
     * Get imagenpromocional
     *
     * @return string 
     */
    public function getImagenpromocional()
    {
        return $this->imagenpromocional;
    }

    /**
     * Set tipopromocion
     *
     * @param integer $tipopromocion
     */
    public function setTipopromocion($tipopromocion)
    {
        $this->tipopromocion = $tipopromocion;
    }

    /**
     * Get tipopromocion
     *
     * @return integer 
     */
    public function getTipopromocion()
    {
        return $this->tipopromocion;
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

    /**
     * Set tipodescuento
     *
     * @param Eros\BackendBundle\Entity\MstTipoDescuento $tipodescuento
     */
    public function setTipodescuento(\Eros\BackendBundle\Entity\MstTipoDescuento $tipodescuento)
    {
        $this->tipodescuento = $tipodescuento;
    }

    /**
     * Get tipodescuento
     *
     * @return Eros\BackendBundle\Entity\MstTipoDescuento 
     */
    public function getTipodescuento()
    {
        return $this->tipodescuento;
    }

    /**
     * Add sidarticulopromocion
     *
     * @param Eros\FrontendBundle\Entity\ProPromocionArticulo $sidarticulopromocion
     */
    public function addProPromocionArticulo(\Eros\FrontendBundle\Entity\ProPromocionArticulo $sidarticulopromocion)
    {
        $this->sidarticulopromocion[] = $sidarticulopromocion;
    }

    /**
     * Get sidarticulopromocion
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getSidarticulopromocion()
    {
        return $this->sidarticulopromocion;
    }

    /**
     * Set estadopromocion
     *
     * @param Eros\BackendBundle\Entity\MstEstadosPromocion $estadopromocion
     */
    public function setEstadopromocion(\Eros\BackendBundle\Entity\MstEstadosPromocion $estadopromocion)
    {
        $this->estadopromocion = $estadopromocion;
    }

    /**
     * Get estadopromocion
     *
     * @return Eros\BackendBundle\Entity\MstEstadosPromocion 
     */
    public function getEstadopromocion()
    {
        return $this->estadopromocion;
    }
}