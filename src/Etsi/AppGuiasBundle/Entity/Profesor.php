<?php
namespace Etsi\AppGuiasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="profesor")
 * @ORM\Entity
 */
class Profesor
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
    protected $nombre;

    /**
     * @ORM\Column(type="string")
     */
    protected $email;

    /**
     * @ORM\Column(type="string")
     */
    protected $tlf;

    /**
     * @ORM\ManyToMany(targetEntity="Guia", mappedBy="profesores")
     */
    protected $guias;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->guias = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Profesor
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    
        return $this;
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
     * Set email
     *
     * @param string $email
     * @return Profesor
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set tlf
     *
     * @param string $tlf
     * @return Profesor
     */
    public function setTlf($tlf)
    {
        $this->tlf = $tlf;
    
        return $this;
    }

    /**
     * Get tlf
     *
     * @return string 
     */
    public function getTlf()
    {
        return $this->tlf;
    }

    /**
     * Add guias
     *
     * @param Etsi\AppGuiasBundle\Entity\Guia $guias
     * @return Profesor
     */
    public function addGuia(\Etsi\AppGuiasBundle\Entity\Guia $guias)
    {
        $this->guias[] = $guias;
    
        return $this;
    }

    /**
     * Remove guias
     *
     * @param Etsi\AppGuiasBundle\Entity\Guia $guias
     */
    public function removeGuia(\Etsi\AppGuiasBundle\Entity\Guia $guias)
    {
        $this->guias->removeElement($guias);
    }

    /**
     * Clear guia
     *
     * @return Profesor
     */
    public function clearGuia()
    {
        $this->guia->clear();
        
        return $this;
    }

    /**
     * Get guias
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getGuias()
    {
        return $this->guias;
    }
}