<?php

namespace Eros\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table (name="MST_TiposEmpresa")
 */
class MstTipoEmpresa
{
    /**
     * @ORM\Id
     * @ORM\Column(name="PidTipoEmpresa",type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="TipoEmpresa",type="string",length=100)
     */
    private $TipoEmpresa;
    
    /**
     * @ORM\Column(name="Codigo",type="string",length=4)
     */
    private $codigo;

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
     * Set TipoEmpresa
     *
     * @param string $tipoEmpresa
     */
    public function setTipoEmpresa($tipoEmpresa)
    {
        $this->TipoEmpresa = $tipoEmpresa;
    }

    /**
     * Get TipoEmpresa
     *
     * @return string 
     */
    public function getTipoEmpresa()
    {
        return $this->TipoEmpresa;
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
}