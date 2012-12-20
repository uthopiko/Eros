<?php

namespace Eros\ExtranetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Eros\ExtranetBundle\Entity\EmpresaPedidoRepository")
 * @ORM\Table (name="Empresas_Pedidos")
 */
class EmpresaPedido
{
    /**
     * @ORM\Id
     * @ORM\Column(name="PidPedido",type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="\Eros\FrontendBundle\Entity\Empresas", inversedBy="EmpresaPedido")
     * @ORM\JoinColumn(name="SidEmpresa", referencedColumnName="PidEmpresa")
     */
    private $empresa;


    /**
     * @ORM\ManyToOne(targetEntity="\Eros\BackendBundle\Entity\MstEstadoPedido", inversedBy="EmpresaPedido")
     * @ORM\JoinColumn(name="SidEstadoPedido", referencedColumnName="PidEstadoPedido")
     */
    private $estadopedido;
    
    /**
     * @ORM\Column(name="NumeroArticulos",type="integer")
     */
    private $numeroarticulos;

     /**
     * @ORM\ManyToOne(targetEntity="Tarifa", inversedBy="EmpresaPedido")
     * @ORM\JoinColumn(name="SidTarifa", referencedColumnName="PidTarifa")
     */
    private $tarifa;

    /**
     * @ORM\ManyToOne(targetEntity="\Eros\FrontendBundle\Entity\Article", inversedBy="EmpresaPedido")
     * @ORM\JoinColumn(name="SidArticulo", referencedColumnName="PidArticulo")
     */
    private $articulo;


    /**
     * @ORM\Column(name="Precio",type="integer")
     */
    private $precio;

    /**
    * @ORM\Column(name="DateAdd",type="datetime")
    **/
    private $dateadd;

    private $atributes;

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
     * Set empresa
     *
     * @param Eros\FrontendBundle\Entity\Empresas $empresa
     */
    public function setEmpresa(\Eros\FrontendBundle\Entity\Empresas $empresa)
    {
        $this->empresa = $empresa;
    }

    /**
     * Get empresa
     *
     * @return Eros\FrontendBundle\Entity\Empresas 
     */
    public function getEmpresa()
    {
        return $this->empresa;
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
     *  Set Atributes of Entity
     *
     *  
     */
    public function setAtributes(){
        $this->atributes = array('Articulo', 'Tarifa', 'EstadoPedido','Empresa','Dateadd','Precio','Numeroarticulos');
    }


    /**
     *  Set Atributes of Entity
     *
     *  
     */
    public function getAtributes(){
        return $this->atributes;
    }


}