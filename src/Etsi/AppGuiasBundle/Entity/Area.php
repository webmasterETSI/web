<?php
namespace Etsi\AppGuiasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="area")
 * @ORM\Entity
 */
class Area
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
    protected $departamento;

    /**
     * @ORM\ManyToMany(targetEntity="Asignatura", mappedBy="areas")
     */
    private $asignaturas;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->asignaturas = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Area
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
     * Set departamento
     *
     * @param string $departamento
     * @return Area
     */
    public function setDepartamento($departamento)
    {
        $this->departamento = $departamento;
    
        return $this;
    }

    /**
     * Get departamento
     *
     * @return string 
     */
    public function getDepartamento()
    {
        return $this->departamento;
    }

    /**
     * Add asignaturas
     *
     * @param \Etsi\AppGuiasBundle\Entity\Asignatura $asignaturas
     * @return Area
     */
    public function addAsignatura(\Etsi\AppGuiasBundle\Entity\Asignatura $asignaturas)
    {
        $this->asignaturas[] = $asignaturas;
    
        return $this;
    }

    /**
     * Remove asignaturas
     *
     * @param \Etsi\AppGuiasBundle\Entity\Asignatura $asignaturas
     */
    public function removeAsignatura(\Etsi\AppGuiasBundle\Entity\Asignatura $asignaturas)
    {
        $this->asignaturas->removeElement($asignaturas);
    }

    /**
     * Get asignaturas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAsignaturas()
    {
        return $this->asignaturas;
    }
}