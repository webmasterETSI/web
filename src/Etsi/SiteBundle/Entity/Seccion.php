<?php
namespace Etsi\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Common\Herramientas;

/**
 * @ORM\Table(name="seccion")
 * @ORM\Entity
 */
class Seccion
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $titulo;

    /**
     * @ORM\Column(type="string")
     */
    protected $slug;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $imagen;

    /**
     * @ORM\Column(type="text")
     */
    protected $descripcion;

    /**
     * @ORM\ManyToMany(targetEntity="Usuario", mappedBy="secciones")
     */
    protected $editores;

    /**
     * @ORM\ManyToMany(targetEntity="Contenido", mappedBy="secciones")
     */
    protected $contenidos;



    /**
     * Constructor
     */
    public function __construct()
    {
        $this->editores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->contenidos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set titulo
     *
     * @param string $titulo
     * @return Seccion
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
        $this->slug = Herramientas::slugify($titulo);
    
        return $this;
    }

    /**
     * Get titulo
     *
     * @return string 
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set imagen
     *
     * @param string $imagen
     * @return Seccion
     */
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;
    
        return $this;
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
     * Set descripcion
     *
     * @param string $descripcion
     * @return Seccion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    
        return $this;
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
     * Add editores
     *
     * @param Etsi\SiteBundle\Entity\Usuario $editores
     * @return Seccion
     */
    public function addEditore(\Etsi\SiteBundle\Entity\Usuario $editores)
    {
        $this->editores[] = $editores;
    
        return $this;
    }

    /**
     * Remove editores
     *
     * @param Etsi\SiteBundle\Entity\Usuario $editores
     */
    public function removeEditore(\Etsi\SiteBundle\Entity\Usuario $editores)
    {
        $this->editores->removeElement($editores);
    }

    /**
     * Get editores
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getEditores()
    {
        return $this->editores;
    }

    /**
     * Add contenidos
     *
     * @param Etsi\SiteBundle\Entity\Contenido $contenidos
     * @return Seccion
     */
    public function addContenido(\Etsi\SiteBundle\Entity\Contenido $contenidos)
    {
        $this->contenidos[] = $contenidos;
    
        return $this;
    }

    /**
     * Remove contenidos
     *
     * @param Etsi\SiteBundle\Entity\Contenido $contenidos
     */
    public function removeContenido(\Etsi\SiteBundle\Entity\Contenido $contenidos)
    {
        $this->contenidos->removeElement($contenidos);
    }

    /**
     * Get contenidos
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getContenidos()
    {
        return $this->contenidos;
    }
}