<?php

namespace Eros\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table (name="PRO_Productos")
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\Column(name="PidProducto",type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="Nombre",type="string",length=100)
     */
    private $nombre;

     /**
     * @ORM\Column(name="Descripcion",type="string",length=250)
     */
    private $descripcion;

	/**
	 * @ORM\ManyToOne(targetEntity="SubCategory")
	 * @ORM\JoinColumn(name="SidSubCategoria", referencedColumnName="PidSubCategoria")
	 */
	protected $subcategoria;
	
	/**
     * @ORM\Column(name="RutaImagen",type="string",length=255)
     */
    private $rutaimagen;

    public $file;
   
     public function getAbsolutePath()
    {
        return null === $this->rutaimagen ? null : $this->getUploadRootDir().'/'.$this->rutaimagen;
    }

    public function getWebPath()
    {
        return null === $this->rutaimagen ? null : $this->getUploadDir().'/'.$this->rutaimagen;
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
    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->file) {
            return;
        }

        // we use the original file name here but you should
        // sanitize it at least to avoid any security issues
        // move takes the target directory and then the target filename to move to
        $this->file->move($this->getUploadDir(), $this->file->getClientOriginalName());

        // set the path property to the filename where you've saved the file
        $this->setRutaimagen($this->getWebPath()."/". $this->file->getClientOriginalName());

        // clean up the file property as you won't need it anymore
        $this->file = null;
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
     * Set descripcion
     *
     * @param string $descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set rutaimagen
     *
     * @param string $rutaimagen
     */
    public function setRutaimagen($rutaimagen)
    {
        $this->rutaimagen = $rutaimagen;
    }

    /**
     * Get rutaimagen
     *
     * @return string 
     */
    public function getRutaimagen()
    {
        return $this->rutaimagen;
    }

    /**
     * Set sidsubcategoria
     *
     * @param Eros\FrontendBundle\Entity\SubCategory $sidsubcategoria
     */
    public function setSidsubcategoria(\Eros\FrontendBundle\Entity\SubCategory $sidsubcategoria)
    {
        $this->sidsubcategoria = $sidsubcategoria;
    }

    /**
     * Get sidsubcategoria
     *
     * @return Eros\FrontendBundle\Entity\SubCategory 
     */
    public function getSidsubcategoria()
    {
        return $this->sidsubcategoria;
    }

    /**
     * Set subcategoria
     *
     * @param Eros\FrontendBundle\Entity\SubCategory $subcategoria
     */
    public function setSubcategoria(\Eros\FrontendBundle\Entity\SubCategory $subcategoria)
    {
        $this->subcategoria = $subcategoria;
    }

    /**
     * Get subcategoria
     *
     * @return Eros\FrontendBundle\Entity\SubCategory 
     */
    public function getSubcategoria()
    {
        return $this->subcategoria;
    }
}