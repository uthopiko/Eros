<?php

namespace Eros\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass="Eros\FrontendBundle\Entity\ProPromocionArticuloRepository")
 * @ORM\Table (name="PRO_PromoArticulosParametros")
 */
class ProPromoArticuloParametros
{
    /**
     * @ORM\Id
     * @ORM\Column(name="PidPromoArticuloParametro",type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $pidpromoarticuloparametro;
    
    /**
     * @ORM\ManyToOne(targetEntity="ProPromocionArticulo", inversedBy="ProPromoArticuloParametros")
     * @ORM\JoinColumn(name="SidArticuloPromocion", referencedColumnName="PidArticuloPromocion")
     */
    private $sidarticulopromocion;

   /**
     * @ORM\ManyToOne(targetEntity="Eros\BackendBundle\Entity\MstParametrosDescuento", inversedBy="ProPromoArticuloParametros")
     * @ORM\JoinColumn(name="SidParametroDescuento", referencedColumnName="PidParametroDescuento")
     */
    private $sidparametrodescuento;

	/**
	 * @ORM\Column(name="Value",type="integer")
	 */
	private $value;

    /**
     * Get pidpromoarticuloparametro
     *
     * @return integer 
     */
    public function getPidpromoarticuloparametro()
    {
        return $this->pidpromoarticuloparametro;
    }

    /**
     * Set value
     *
     * @param integer $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Get value
     *
     * @return integer 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set sidarticulopromocion
     *
     * @param Eros\FrontendBundle\Entity\ProPromocionArticulo $sidarticulopromocion
     */
    public function setSidarticulopromocion(\Eros\FrontendBundle\Entity\ProPromocionArticulo $sidarticulopromocion)
    {
        $this->sidarticulopromocion = $sidarticulopromocion;
    }

    /**
     * Get sidarticulopromocion
     *
     * @return Eros\FrontendBundle\Entity\ProPromocionArticulo 
     */
    public function getSidarticulopromocion()
    {
        return $this->sidarticulopromocion;
    }

    /**
     * Set sidparametrodescuento
     *
     * @param Eros\BackendBundle\Entity\MstParametrosDescuento $sidparametrodescuento
     */
    public function setSidparametrodescuento(\Eros\BackendBundle\Entity\MstParametrosDescuento $sidparametrodescuento)
    {
        $this->sidparametrodescuento = $sidparametrodescuento;
    }

    /**
     * Get sidparametrodescuento
     *
     * @return Eros\BackendBundle\Entity\MstParametrosDescuento 
     */
    public function getSidparametrodescuento()
    {
        return $this->sidparametrodescuento;
    }
}