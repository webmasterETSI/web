<?php
namespace Etsi\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Common\Herramientas;

/**
 * @ORM\Table(name="contenido")
 * @ORM\Entity
 */
class Contenido
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
     * @ORM\Column(type="text", nullable=true)
     */
    protected $resumen;

    /**
     * @ORM\Column(type="text")
     */
    protected $descripcion;

    /**
     * @ORM\Column(type="date")
     */
    protected $fecha;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="contenidos")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     */
    protected $autor;

    /**
     * @ORM\ManyToMany(targetEntity="Seccion", inversedBy="contenidos")
     * @ORM\JoinTable(name="contenido_seccion")
     */
    protected $secciones;



    /**
     * Constructor
     */
    public function __construct()
    {
        $this->secciones = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Contenido
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
     * @return Contenido
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
     * Set resumen
     *
     * @param string $resumen
     * @return Contenido
     */
    public function setResumen($resumen)
    {
        $this->resumen = $resumen;
    
        return $this;
    }

    /**
     * Get resumen
     *
     * @return string 
     */
    public function getResumen()
    {
        return $this->resumen;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Contenido
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
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Contenido
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    
        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set autor
     *
     * @param Etsi\SiteBundle\Entity\Usuario $autor
     * @return Contenido
     */
    public function setAutor(\Etsi\SiteBundle\Entity\Usuario $autor = null)
    {
        $this->autor = $autor;
    
        return $this;
    }

    /**
     * Get autor
     *
     * @return Etsi\SiteBundle\Entity\Usuario 
     */
    public function getAutor()
    {
        return $this->autor;
    }

    /**
     * Add secciones
     *
     * @param Etsi\SiteBundle\Entity\Seccion $secciones
     * @return Contenido
     */
    public function addSeccion(\Etsi\SiteBundle\Entity\Seccion $secciones)
    {
        $this->secciones[] = $secciones;
    
        return $this;
    }

    /**
     * Remove secciones
     *
     * @param Etsi\SiteBundle\Entity\Seccion $secciones
     */
    public function removeSeccion(\Etsi\SiteBundle\Entity\Seccion $secciones)
    {
        $this->secciones->removeElement($secciones);
    }

    /**
     * Get secciones
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getSecciones()
    {
        return $this->secciones;
    }
}