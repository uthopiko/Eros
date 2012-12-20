<?php

namespace Eros\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Eros\FrontendBundle\Entity\ProPromocionArticuloRepository")
 * @ORM\Table (name="PRO_PromocionesArticulos")
 */
class ProPromocionArticulo
{
    /**
     * @ORM\Id
     * @ORM\Column(name="PidArticuloPromocion",type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="CliPromociones", inversedBy="ProPromocionArticulo")
     * @ORM\JoinColumn(name="SidPromocion", referencedColumnName="PidPromocion")
     */
    private $sidpromocion;

   /**
     * @ORM\ManyToOne(targetEntity="Article", inversedBy="ProPromocionArticulo")
     * @ORM\JoinColumn(name="SidArticulo", referencedColumnName="PidArticulo")
     */
    private $sidarticulo;
	
    /**
     * @ORM\ManyToOne(targetEntity="\Eros\BackendBundle\Entity\MstTipoDescuento", inversedBy="ProPromocionArticulo")
     * @ORM\JoinColumn(name="SidTipoDescuento", referencedColumnName="PidTipoDescuento")
     */
    private $tipodescuento;
    
    
	/**
	 * @ORM\Column(name="Stock",type="integer")
	 */
	private $stock;

  

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
     * Set stock
     *
     * @param integer $stock
     */
    public function setStock($stock)
    {
        $this->stock = $stock;
    }

    /**
     * Get stock
     *
     * @return integer 
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Set sidpromocion
     *
     * @param Eros\FrontendBundle\Entity\CliPromociones $sidpromocion
     */
    public function setSidpromocion(\Eros\FrontendBundle\Entity\CliPromociones $sidpromocion)
    {
        $this->sidpromocion = $sidpromocion;
    }

    /**
     * Get sidpromocion
     *
     * @return Eros\FrontendBundle\Entity\CliPromociones 
     */
    public function getSidpromocion()
    {
        return $this->sidpromocion;
    }

    /**
     * Set sidarticulo
     *
     * @param Eros\FrontendBundle\Entity\Article $sidarticulo
     */
    public function setSidarticulo(\Eros\FrontendBundle\Entity\Article $sidarticulo)
    {
        $this->sidarticulo = $sidarticulo;
    }

    /**
     * Get sidarticulo
     *
     * @return Eros\FrontendBundle\Entity\Article 
     */
    public function getSidarticulo()
    {
        return $this->sidarticulo;
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
}