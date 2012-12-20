<?php

namespace Eros\ExtranetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Eros\ExtranetBundle\Entity\SpecsRepository")
 * @ORM\Table (name="Specs")
 */
class Specs
{
    /**
     * @ORM\Id
     * @ORM\Column(name="PidSpec",type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="Specification",type="string",length=100)
     */
    private $specification;

    /**
     * @ORM\Column(name="Value",type="string",length=200)
     */
    private $value;

    /**
    * @ORM\ManyToOne(targetEntity="\Eros\ExtranetBundle\Entity\SpecsSection")
    * @ORM\JoinColumn(name="SidSection", referencedColumnName="PidSection")
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
     * Set specification
     *
     * @param string $specification
     */
    public function setSpecification($specification)
    {
        $this->specification = $specification;
    }

    /**
     * Get specification
     *
     * @return string 
     */
    public function getSpecification()
    {
        return $this->specification;
    }

    /**
     * Set value
     *
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
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

    /**
     * Set section
     *
     * @param Eros\ExtranetBundle\Entity\SpecsSection $section
     */
    public function setSection(\Eros\ExtranetBundle\Entity\SpecsSection $section)
    {
        $this->section = $section;
    }

    /**
     * Get section
     *
     * @return Eros\ExtranetBundle\Entity\SpecsSection 
     */
    public function getSection()
    {
        return $this->section;
    }
}