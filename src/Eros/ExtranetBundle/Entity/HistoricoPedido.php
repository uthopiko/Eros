<?php

namespace Eros\ExtranetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table (name="Empresa_Historico_Pedido")
 */
class HistoricoPedido
{
    /**
     * @ORM\Id
     * @ORM\Column(name="PidHistoricoPedido",type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @ORM\ManyToOne(targetEntity="\Eros\ExtranetBundle\Entity\EmpresaPedido", inversedBy="HistoricoPedido")
     * @ORM\JoinColumn(name="SidPedido", referencedColumnName="PidPedido")
     */
    private $pedido;

    /**
     * @ORM\ManyToOne(targetEntity="\Eros\BackendBundle\Entity\MstEstadoPedido", inversedBy="HistoricoPedido")
     * @ORM\JoinColumn(name="SidEstadoPedido", referencedColumnName="PidEstadoPedido")
     */
    private $estadopedido;
    
    /**
     * @ORM\Column(name="NumeroArticulos",type="integer")
     */
    private $numeroarticulos;

     /**
     * @ORM\ManyToOne(targetEntity="Tarifa", inversedBy="HistoricoPedido")
     * @ORM\JoinColumn(name="SidTarifa", referencedColumnName="PidTarifa")
     */
    private $tarifa;

    /**
     * @ORM\Column(name="Precio",type="integer")
     */
    private $precio;

    /**
    * @ORM\Column(name="DateModified",type="datetime")
    **/
    private $datemodified;

    /**
    * @ORM\Column(name="Active",type="boolean")
    **/
    private $active;
  

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
     * Set numeroarticulos
     *
     * @param integer $numeroarticulos
     */
    public function setNumeroarticulos($numeroarticulos)
    {
        $this->numeroarticulos = $numeroarticulos;
    }

    /**
     * Get numeroarticulos
     *
     * @return integer 
     */
    public function getNumeroarticulos()
    {
        return $this->numeroarticulos;
    }

    /**
     * Set precio
     *
     * @param integer $precio
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;
    }

    /**
     * Get precio
     *
     * @return integer 
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Set datemodified
     *
     * @param datetime $datemodified
     */
    public function setDatemodified($datemodified)
    {
        $this->datemodified = $datemodified;
    }

    /**
     * Get datemodified
     *
     * @return datetime 
     */
    public function getDatemodified()
    {
        return $this->datemodified;
    }

    /**
     * Set pedido
     *
     * @param Eros\ExtranetBundle\Entity\EmpresaPedido $pedido
     */
    public function setPedido(\Eros\ExtranetBundle\Entity\EmpresaPedido $pedido)
    {
        $this->pedido = $pedido;
    }

    /**
     * Get pedido
     *
     * @return Eros\ExtranetBundle\Entity\EmpresaPedido 
     */
    public function getPedido()
    {
        return $this->pedido;
    }

    /**
     * Set estadopedido
     *
     * @param Eros\BackendBundle\Entity\MstEstadoPedido $estadopedido
     */
    public function setEstadopedido(\Eros\BackendBundle\Entity\MstEstadoPedido $estadopedido)
    {
        $this->estadopedido = $estadopedido;
    }

    /**
     * Get estadopedido
     *
     * @return Eros\BackendBundle\Entity\MstEstadoPedido 
     */
    public function getEstadopedido()
    {
        return $this->estadopedido;
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

    /**
     * Set active
     *
     * @param boolean $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }
}