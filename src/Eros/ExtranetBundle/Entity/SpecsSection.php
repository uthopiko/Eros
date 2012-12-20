<?php

namespace Eros\ExtranetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table (name="SpecsSection")
 */
class SpecsSection
{
    /**
     * @ORM\Id
     * @ORM\Column(name="PidSection",type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="Section",type="string",length=100)
     */
    private $section;
    
    /**
    * @ORM\ManyToOne(targetEntity="\Eros\FrontendBundle\Entity\Article")
    * @ORM\JoinColumn(name="SidArticulo", referencedColumnName="PidArticulo")
    */
    private $articulo;

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
     * Set section
     *
     * @param string $section
     */
    public function setSection($section)
    {
        $this->section = $section;
    }

    /**
     * Get section
     *
     * @return string 
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * Set articulo
     *
     * @param Eros\FrontendBundle\Entity\Article $articulo
     */
    public function setArticulo(\Eros\FrontendBundle\Entity\Article $articulo)
    {
        $this->articulo = $articulo;
    }

    /**
     * Get articulo
     *
     * @return Eros\FrontendBundle\Entity\Article 
     */
    public function getArticulo()
    {
        return $this->articulo;
    }
}