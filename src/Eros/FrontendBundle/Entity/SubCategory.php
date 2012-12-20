<?php

namespace Eros\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table (name="PRO_SubCategorias")
 */
class SubCategory
{
    /**
     * @ORM\Id
     * @ORM\Column(name="PidSubCategoria",type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    
    /**
     * @ORM\Column(name="SubCategoria",type="string",length=45)
     */
    private $subcategoria;
    
    /**
	 * @ORM\ManyToOne(targetEntity="Category")
	 * @ORM\JoinColumn(name="SidCategoria", referencedColumnName="PidCategoria")
	 */
    private $categoria;


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
     * Set subcategoria
     *
     * @param string $subcategoria
     */
    public function setSubcategoria($subcategoria)
    {
        $this->subcategoria = $subcategoria;
    }

    /**
     * Get subcategoria
     *
     * @return string 
     */
    public function getSubcategoria()
    {
        return $this->subcategoria;
    }

    /**
     * Set categoria
     *
     * @param Eros\FrontendBundle\Entity\Category $categoria
     */
    public function setCategoria(\Eros\FrontendBundle\Entity\Category $categoria)
    {
        $this->categoria = $categoria;
    }

    /**
     * Get categoria
     *
     * @return Eros\FrontendBundle\Entity\Category 
     */
    public function getCategoria()
    {
        return $this->categoria;
    }
}