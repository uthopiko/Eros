<?php

namespace Eros\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table (name="MST_EstadosPromocion")
 */
class MstEstadosPromocion
{
    /**
     * @ORM\Id
     * @ORM\Column(name="PidEstadoPromocion",type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $pidestadopromocion;

    /**
     * @ORM\Column(name="Estado",type="string",length=100)
     */
    private $estado;
	
	/**
     * @ORM\Column(name="Codigo",type="string",length=4)
     */
    private $codigo;

    /**
     * Get pidestadopromocion
     *
     * @return integer 
     */
    public function getPidestadopromocion()
    {
        return $this->pidestadopromocion;
    }

    /**
     * Set promocion
     *
     * @param string $promocion
     */
    public function setPromocion($promocion)
    {
        $this->promocion = $promocion;
    }

    /**
     * Get promocion
     *
     * @return string 
     */
    public function getPromocion()
    {
        return $this->promocion;
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
     * Set estado
     *
     * @param string $estado
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    /**
     * Get estado
     *
     * @return string 
     */
    public function getEstado()
    {
        return $this->estado;
    }
}