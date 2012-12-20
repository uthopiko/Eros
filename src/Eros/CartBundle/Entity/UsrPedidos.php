<?php

namespace Eros\CartBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Eros\CartBundle\Entity\UsrPedidosRepository")
 * @ORM\Table (name="USR_Pedidos")
 */
class UsrPedidos
{

    /**
     * @ORM\Id
     * @ORM\Column(name="PidPedido",type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="\Eros\FrontendBundle\Entity\User", inversedBy="UsrPedidos")
     * @ORM\JoinColumn(name="SidUsuario", referencedColumnName="PidUsuario")
     */
    private $user;

   /**
     * @ORM\ManyToOne(targetEntity="\Eros\FrontendBundle\Entity\Article", inversedBy="UsrPedidos")
     * @ORM\JoinColumn(name="SidArticulo", referencedColumnName="PidArticulo")
     */
    private $articulo;

    /**
     * @ORM\ManyToOne(targetEntity="\Eros\BackendBundle\Entity\MstEstadoPedido", inversedBy="UsrPedidos")
     * @ORM\JoinColumn(name="SidEstadoPedido", referencedColumnName="PidEstadoPedido")
     */
    private $sidestadopedido;
	
	/**
	 * @ORM\Column(name="NumeroArticulos",type="integer")
	 */
	private $numeroarticulos;

    /**
     * @ORM\Column(name="Precio",type="integer")
     */
    private $precio;

    /**
    * @ORM\Column(name="DateAdd",type="datetime")
    **/
    private $dateadd;

    
    public function serialize() {
        return "{".$this->getArticulo()->getPidarticulo().",".$this->getSidestadopedido()->getId().",".$this->numeroarticulos.",".$this->precio."}";
    }
    

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
     * Set dateadd
     *
     * @param datetime $dateadd
     */
    public function setDateadd($dateadd)
    {
        $this->dateadd = $dateadd;
    }

    /**
     * Get dateadd
     *
     * @return datetime 
     */
    public function getDateadd()
    {
        return $this->dateadd;
    }

    /**
     * Set user
     *
     * @param Eros\FrontendBundle\Entity\User $user
     */
    public function setUser(\Eros\FrontendBundle\Entity\User $user)
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return Eros\FrontendBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
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
     * Set sidestadopedido
     *
     * @param Eros\BackendBundle\Entity\MstEstadoPedido $sidestadopedido
     */
    public function setSidestadopedido(\Eros\BackendBundle\Entity\MstEstadoPedido $sidestadopedido)
    {
        $this->sidestadopedido = $sidestadopedido;
    }

    /**
     * Get sidestadopedido
     *
     * @return Eros\BackendBundle\Entity\MstEstadoPedido 
     */
    public function getSidestadopedido()
    {
        return $this->sidestadopedido;
    }
}