<?php
namespace Etsi\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="usuario")
 * @ORM\Entity
 */
class Usuario
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
    protected $nick;

    /**
     * @ORM\Column(type="string")
     */
    protected $pass;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $imagen;

    /**
    * @ORM\OneToMany(targetEntity="Contenido", mappedBy="autor")
    */
    protected $contenidos;

    /**
     * @ORM\ManyToMany(targetEntity="Seccion", inversedBy="editores")
     * @ORM\JoinTable(name="usuari_seccion")
     */
    protected $secciones;



    /**
     * Constructor
     */
    public function __construct()
    {
        $this->contenidos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nick
     *
     * @param string $nick
     * @return Usuario
     */
    public function setNick($nick)
    {
        $this->nick = $nick;
    
        return $this;
    }

    /**
     * Get nick
     *
     * @return string 
     */
    public function getNick()
    {
        return $this->nick;
    }

    /**
     * Set pass
     *
     * @param string $pass
     * @return Usuario
     */
    public function setPass($pass)
    {
        $this->pass = $pass;
    
        return $this;
    }

    /**
     * Get pass
     *
     * @return string 
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * Set imagen
     *
     * @param string $imagen
     * @return Usuario
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
     * Add contenidos
     *
     * @param Etsi\SiteBundle\Entity\Contenido $contenidos
     * @return Usuario
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

    /**
     * Add secciones
     *
     * @param Etsi\SiteBundle\Entity\Seccion $secciones
     * @return Usuario
     */
    public function addSeccione(\Etsi\SiteBundle\Entity\Seccion $secciones)
    {
        $this->secciones[] = $secciones;
    
        return $this;
    }

    /**
     * Remove secciones
     *
     * @param Etsi\SiteBundle\Entity\Seccion $secciones
     */
    public function removeSeccione(\Etsi\SiteBundle\Entity\Seccion $secciones)
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