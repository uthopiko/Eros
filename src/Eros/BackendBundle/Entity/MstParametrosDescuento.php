<?php

namespace Eros\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table (name="MST_ParametroDescuento")
 */
class MstParametrosDescuento
{
    /**
     * @ORM\Id
     * @ORM\Column(name="PidParametroDescuento",type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="Parametro",type="string",length=100)
     */
    private $parametro;

	/**
	 * @ORM\ManyToOne(targetEntity="\Eros\BackendBundle\Entity\MstTipoDescuento")
	 * @ORM\JoinColumn(name="SidTipoDescuento", referencedColumnName="PidTipoDescuento")
	 */
    private $sidtipodescuento;

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
     * Set parametro
     *
     * @param string $parametro
     */
    public function setParametro($parametro)
    {
        $this->parametro = $parametro;
    }

    /**
     * Get parametro
     *
     * @return string 
     */
    public function getParametro()
    {
        return $this->parametro;
    }

    /**
     * Set sidtipodescuento
     *
     * @param Eros\BackendBundle\Entity\MstTipoDescuento $sidtipodescuento
     */
    public function setSidtipodescuento(\Eros\BackendBundle\Entity\MstTipoDescuento $sidtipodescuento)
    {
        $this->sidtipodescuento = $sidtipodescuento;
    }

    /**
     * Get sidtipodescuento
     *
     * @return Eros\BackendBundle\Entity\MstTipoDescuento 
     */
    public function getSidtipodescuento()
    {
        return $this->sidtipodescuento;
    }
}