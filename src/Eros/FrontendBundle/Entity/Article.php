<?php

namespace Eros\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Eros\FrontendBundle\Entity\ArticleRepository")
 * @ORM\Table (name="PRO_Articulos")
 * @ORM\HasLifecycleCallbacks
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\Column(name="PidArticulo",type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $pidarticulo;
    
    /**
     * @ORM\ManyToOne(targetEntity="Empresas")
     * @ORM\JoinColumn(name="SidEmpresa", referencedColumnName="PidEmpresa")
     */
    private $empresa;

    /**
     * @ORM\Column(name="Nombre",type="string",nullable=false)
     */
    private $nombre;
     
    /**
     * @ORM\Column(name="Medida",type="string",nullable=true)
     */
    private $medida;
     
    /**
     * @ORM\Column(name="Stock",type="string",nullable=true)
     */
    private $stock;
    
    
    /**
     * @ORM\Column(name="Precio",type="decimal",nullable=false)
     */
    private $precio;

   /**
     * @ORM\Column(name="Imagen",type="string",length=255,nullable=true)
     */
    private $imagen;

    /**
	 * @ORM\ManyToOne(targetEntity="Product")
	 * @ORM\JoinColumn(name="SidProducto", referencedColumnName="PidProducto",nullable=true)
	 */
    private $producto;

    /**
	 * @ORM\ManyToOne(targetEntity="Category")
	 * @ORM\JoinColumn(name="SidCategoria", referencedColumnName="PidCategoria",nullable=true)
	 */
    private $category;

    /**
	 * @ORM\ManyToOne(targetEntity="SubCategory")
	 * @ORM\JoinColumn(name="SidSubCategoria", referencedColumnName="PidSubCategoria",nullable=true)
	 */
    private $subcategory;

     /**
	 * @ORM\ManyToOne(targetEntity="\Eros\BackendBundle\Entity\MstUnidadMedida")
	 * @ORM\JoinColumn(name="SidUnidadMedida", referencedColumnName="PidUnidadMedida")
	 */
    private $unidadmedida;


    /**
     * @ORM\ManyToOne(targetEntity="ProMarca")
     * @ORM\JoinColumn(name="SidMarca", referencedColumnName="PidMarca")
     */
    private $marca;
     
     /**
     * @ORM\Column(name="Orden",type="integer",nullable=false)
     */
    private $orden;

     /**
     * @ORM\Column(name="PorMayor",type="boolean",nullable=false)
     */
    private $pormayor;

    /**
     * @ORM\Column(name="PorMenor",type="boolean",nullable=false)
     */
    private $pormenor;

    /**
     * @ORM\Column(name="Description",type="string",nullable=false)
     */
    private $description;
    

    public $file;

    public $preciodescuento;
   
   public function getAbsolutePath()
    {
        return null === $this->imagen ? null : $this->getUploadRootDir().'/'.$this->imagen;
    }

    public function getWebPath()
    {
        return null === $this->imagen ? null : $this->getUploadDir().'/'.$this->imagen;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw when displaying uploaded doc/image in the view.
        return 'uploads/productos';
    }
    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->file) {
            // do whatever you want to generate a unique name
            $this->imagen =  uniqid().".".$this->file->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->file) {
            return;
        }

        // we use the original file name here but you should
        // sanitize it at least to avoid any security issues
        // move takes the target directory and then the target filename to move to
        $this->file->move($this->getUploadDir(), $this->imagen);

        // clean up the file property as you won't need it anymore
        unset($file);
    }


    /**
     * Get pidarticulo
     *
     * @return integer 
     */
    public function getPidarticulo()
    {
        return $this->pidarticulo;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set medida
     *
     * @param string $medida
     */
    public function setMedida($medida)
    {
        $this->medida = $medida;
    }

    /**
     * Get medida
     *
     * @return string 
     */
    public function getMedida()
    {
        return $this->medida;
    }

    /**
     * Set stock
     *
     * @param string $stock
     */
    public function setStock($stock)
    {
        $this->stock = $stock;
    }

    /**
     * Get stock
     *
     * @return string 
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Set precio
     *
     * @param decimal $precio
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;
    }

    /**
     * Get precio
     *
     * @return decimal 
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Set imagen
     *
     * @param string $imagen
     */
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;
    }

    /**
     * Get imagen
     *
     * @return string 
     */
    public function getImagen()
    {
        return $this->imagen;
    }

    /**
     * Set orden
     *
     * @param integer $orden
     */
    public function setOrden($orden)
    {
        $this->orden = $orden;
    }

    /**
     * Get orden
     *
     * @return integer 
     */
    public function getOrden()
    {
        return $this->orden;
    }

    /**
     * Set pormayor
     *
     * @param boolean $pormayor
     */
    public function setPormayor($pormayor)
    {
        $this->pormayor = $pormayor;
    }

    /**
     * Get pormayor
     *
     * @return boolean 
     */
    public function getPormayor()
    {
        return $this->pormayor;
    }

    /**
     * Set pormenor
     *
     * @param boolean $pormenor
     */
    public function setPormenor($pormenor)
    {
        $this->pormenor = $pormenor;
    }

    /**
     * Get pormenor
     *
     * @return boolean 
     */
    public function getPormenor()
    {
        return $this->pormenor;
    }

    /**
     * Set description
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
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
     * Set producto
     *
     * @param Eros\FrontendBundle\Entity\Product $producto
     */
    public function setProducto(\Eros\FrontendBundle\Entity\Product $producto)
    {
        $this->producto = $producto;
    }

    /**
     * Get producto
     *
     * @return Eros\FrontendBundle\Entity\Product 
     */
    public function getProducto()
    {
        return $this->producto;
    }

    /**
     * Set marca
     *
     * @param Eros\FrontendBundle\Entity\ProMarca $marca
     */
    public function setMarca(\Eros\FrontendBundle\Entity\ProMarca $marca)
    {
        $this->marca = $marca;
    }

    /**
     * Get marca
     *
     * @return Eros\FrontendBundle\Entity\ProMarca 
     */
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * Set unidadmedida
     *
     * @param Eros\BackendBundle\Entity\MstUnidadMedida $unidadmedida
     */
    public function setUnidadmedida(\Eros\BackendBundle\Entity\MstUnidadMedida $unidadmedida)
    {
        $this->unidadmedida = $unidadmedida;
    }

    /**
     * Get unidadmedida
     *
     * @return Eros\BackendBundle\Entity\MstUnidadMedida 
     */
    public function getUnidadmedida()
    {
        return $this->unidadmedida;
    }

    /**
     * Set category
     *
     * @param Eros\FrontendBundle\Entity\Category $category
     */
    public function setCategory(\Eros\FrontendBundle\Entity\Category $category)
    {
        $this->category = $category;
    }

    /**
     * Get category
     *
     * @return Eros\FrontendBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set subcategory
     *
     * @param Eros\FrontendBundle\Entity\SubCategory $subcategory
     */
    public function setSubcategory(\Eros\FrontendBundle\Entity\SubCategory $subcategory)
    {
        $this->subcategory = $subcategory;
    }

    /**
     * Get subcategory
     *
     * @return Eros\FrontendBundle\Entity\SubCategory 
     */
    public function getSubcategory()
    {
        return $this->subcategory;
    }
}