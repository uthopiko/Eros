<?php

namespace Eros\ExtranetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Eros\ExtranetBundle\Entity\TarifaArticuloRepository")
 * @ORM\Table (name="TarifasArticulos")
 */
class TarifaArticulo
{
    /**
     * @ORM\Id
     * @ORM\Column(name="PidTarifaArticulo",type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @ORM\ManyToOne(targetEntity="\Eros\FrontendBundle\Entity\Article", inversedBy="TarifasArticulos")
     * @ORM\JoinColumn(name="SidArticulo", referencedColumnName="PidArticulo")
     */
    private $articulo;

   /**
     * @ORM\ManyToOne(targetEntity="Tarifa", inversedBy="UsrPedidos")
     * @ORM\JoinColumn(name="SidTarifa", referencedColumnName="PidTarifa")
     */
    private $tarifa;

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
     * Set tarifa
     *
     * @param Eros\ExtranetBundle\Entity\Tarifa $tarifa
     */
    public function setTarifa(\Eros\ExtranetBundle\Entity\Tarifa $tarifa)
    {
        $this->tarifa = $tarifa;
    }

    /**
     * Get tarifa
     *
     * @return Eros\ExtranetBundle\Entity\Tarifa 
     */
    public function getTarifa()
    {
        return $this->tarifa;
    }
}