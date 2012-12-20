<?php

namespace Eros\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table (name="MST_EstadoPedido")
 */
class MstEstadoPedido
{
    /**
     * @ORM\Id
     * @ORM\Column(name="PidEstadoPedido",type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="EstadoPedido",type="string",length=100)
     */
    private $estadopedido;
    
    /**
     * @ORM\Column(name="Codigo",type="string",length=10)
     */
    private $codigo;

    /**
     * @ORM\Column(name="TipoPedido",type="string",length=10)
     */
    private $tipopedido;

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
     * Set estadopedido
     *
     * @param string $estadopedido
     */
    public function setEstadopedido($estadopedido)
    {
        $this->estadopedido = $estadopedido;
    }

    /**
     * Get estadopedido
     *
     * @return string 
     */
    public function getEstadopedido()
    {
        return $this->estadopedido;
    }

    /**
     * Set codigo
     *
     * @param string $codigo
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    /**
     * Get codigo
     *
     * @return string 
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set tipopedido
     *
     * @param string $tipopedido
     */
    public function setTipopedido($tipopedido)
    {
        $this->tipopedido = $tipopedido;
    }

    /**
     * Get tipopedido
     *
     * @return string 
     */
    public function getTipopedido()
    {
        return $this->tipopedido;
    }
}