<?php

namespace Eros\ExtranetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table (name="ArticuloMedida")
 */
class ArticuloMedida
{
    /**
     * @ORM\Id
     * @ORM\Column(name="PidArticuloMedida",type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @ORM\ManyToOne(targetEntity="\Eros\FrontendBundle\Entity\Article", inversedBy="ArticuloMedidas")
     * @ORM\JoinColumn(name="SidArticulo", referencedColumnName="PidArticulo")
     */
    private $articulo;

   /**
     * @ORM\ManyToOne(targetEntity="\Eros\BackendBundle\Entity\MstValoresMedidas", inversedBy="ArticuloMedidas")
     * @ORM\JoinColumn(name="SidValor", referencedColumnName="PidValorMedida")
     */
    private $valor;

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
     * Set valor
     *
     * @param Eros\BackendBundle\Entity\MstValoresMedidas $valor
     */
    public function setValor(\Eros\BackendBundle\Entity\MstValoresMedidas $valor)
    {
        $this->valor = $valor;
    }

    /**
     * Get valor
     *
     * @return Eros\BackendBundle\Entity\MstValoresMedidas 
     */
    public function getValor()
    {
        return $this->valor;
    }
}