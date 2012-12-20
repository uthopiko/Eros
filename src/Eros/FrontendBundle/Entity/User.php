<?php
// src/Eros/FrontendBundle/Entity/User.php

namespace Eros\FrontendBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Eros\FrontendBundle\Entity\UserRepository")
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(name="PidUsuario",type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
	
	/**
	 * @ORM\ManyToMany(targetEntity="SubCategory")
	 * @ORM\JoinTable(name="USR_Preferencias",
     *      joinColumns={@ORM\JoinColumn(name="SidUsuario", referencedColumnName="PidUsuario")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="SidSubCategoria", referencedColumnName="PidSubCategoria")}
     *      )
	 */
	protected $sidSubCategoria;

   /**
     * @ORM\ManyToOne(targetEntity="UserData")
     * @ORM\JoinColumn(name="SidUserData", referencedColumnName="PidUserData")
     */
    protected $userdata;

    /**
    * @ORM\ManyToMany(targetEntity="Empresas")
    * @ORM\JoinTable(name="EmpresasClientes",
    *      joinColumns={@ORM\JoinColumn(name="SidUsuario", referencedColumnName="PidUsuario")},
    *      inverseJoinColumns={@ORM\JoinColumn(name="SidEmpresa", referencedColumnName="PidEmpresa")})
    */
    protected $empresas;

    /**
     * Get empresas
     *
     * @return string
     */
    public function getEmpresasString()
    {
        $strCliente= '';
        foreach($this->empresas as $empr){
            $strCliente .= $empr->GetId().",";
        }
        return $strCliente;
    }

    public function __construct()
    {
        parent::__construct();
        $this->sidSubCategoria = new \Doctrine\Common\Collections\ArrayCollection();
         $this->empresas = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add sidSubCategoria
     *
     * @param Eros\FrontendBundle\Entity\SubCategory $sidSubCategoria
     */
    public function addSubCategory(\Eros\FrontendBundle\Entity\SubCategory $sidSubCategoria)
    {
        $this->sidSubCategoria[] = $sidSubCategoria;
    }

    /**
     * Get sidSubCategoria
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getSidSubCategoria()
    {
        return $this->sidSubCategoria;
    }

    /**
     * Set userdata
     *
     * @param Eros\FrontendBundle\Entity\UserData $userdata
     */
    public function setUserdata(\Eros\FrontendBundle\Entity\UserData $userdata)
    {
        $this->userdata = $userdata;
    }

    /**
     * Get userdata
     *
     * @return Eros\FrontendBundle\Entity\UserData 
     */
    public function getUserdata()
    {
        return $this->userdata;
    }

    /**
     * Add empresas
     *
     * @param Eros\FrontendBundle\Entity\Empresas $empresas
     */
    public function addEmpresas(\Eros\FrontendBundle\Entity\Empresas $empresas)
    {
        $this->empresas[] = $empresas;
    }

    public function removeEmpresas($Empresas)
    {
        return $this->empresas->removeElement($Empresas);
    }

    /**
     * Get empresas
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getEmpresas()
    {
        return $this->empresas;
    }
}