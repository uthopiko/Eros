<?php

namespace Eros\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table (name="PRO_Categorias")
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\Column(name="PidCategoria",type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $pidcategoria;

    
    /**
     * @ORM\Column(name="Categoria",type="string",length=45)
     */
    private $categoria;

    /**
     * Get pidcategoria
     *
     * @return integer 
     */
    public function getPidcategoria()
    {
        return $this->pidcategoria;
    }

    /**
     * Set categoria
     *
     * @param string $categoria
     */
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;
    }

    /**
     * Get categoria
     *
     * @return string 
     */
    public function getCategoria()
    {
        return $this->categoria;
    }
}