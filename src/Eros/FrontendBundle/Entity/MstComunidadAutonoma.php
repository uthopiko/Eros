<?php

namespace Eros\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table (name="MST_ComunidadAutonoma")
 */
class MstComunidadAutonoma
{
    /**
     * @ORM\Id
     * @ORM\Column(name="PidComunidadAutonoma",type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $pidcomunidadAutonoma;

    /**
     * @ORM\Column(name="ComunidadAutonoma",type="string",length=100)
     */
    private $comunidadautonoma;
    
       /**
     * @ORM\Column(name="Codigo",type="string",length=2)
     */
    private $Codigo;

    /**
     * Get pidcomunidadAutonoma
     *
     * @return integer 
     */
    public function getPidcomunidadAutonoma()
    {
        return $this->pidcomunidadAutonoma;
    }

    /**
     * Set comunidadautonoma
     *
     * @param string $comunidadautonoma
     */
    public function setComunidadautonoma($comunidadautonoma)
    {
        $this->comunidadautonoma = $comunidadautonoma;
    }

    /**
     * Get comunidadautonoma
     *
     * @return string 
     */
    public function getComunidadautonoma()
    {
        return $this->comunidadautonoma;
    }

    /**
     * Set Codigo
     *
     * @param string $codigo
     */
    public function setCodigo($codigo)
    {
        $this->Codigo = $codigo;
    }

    /**
     * Get Codigo
     *
     * @return string 
     */
    public function getCodigo()
    {
        return $this->Codigo;
    }
}