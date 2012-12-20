<?php

namespace Eros\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Eros\FrontendBundle\Entity\MstParametrosDescuento
 */
class MstParametrosDescuento
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $parametro
     */
    private $parametro;

    /**
     * @var Eros\BackendBundle\Entity\MstTipoDescuento
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