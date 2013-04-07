<?php
namespace Etsi\AppGuiasBundle\Entity;

use Doctrine\ORM\Mapping as ORM,
    JMS\Serializer\Annotation\ExclusionPolicy,
    JMS\Serializer\Annotation\Expose;

/**
 * @ORM\Table(name="grado")
 * @ORM\Entity
 *
 * @ExclusionPolicy("all")
 */
class Grado
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @Expose
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     *
     * @Expose
     */
    protected $nombre;

    /**
     * @ORM\ManyToMany(targetEntity="Asignatura", mappedBy="grados")
     */
    private $asignaturas;

    /**
     * @ORM\OneToMany(targetEntity="Grado", mappedBy="gradoPadre")
     */
    private $itinerarios;

    /**
     * @ORM\ManyToOne(targetEntity="Grado", inversedBy="itinerarios")
     * @ORM\JoinColumn(name="padre_id", referencedColumnName="id")
     *
     * @Expose
     */
    private $gradoPadre;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->asignaturas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->itinerarios = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Grado
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
     * Add asignaturas
     *
     * @param Etsi\AppGuiasBundle\Entity\Asignatura $asignaturas
     * @return Grado
     */
    public function addAsignatura(\Etsi\AppGuiasBundle\Entity\Asignatura $asignaturas)
    {
        $this->asignaturas[] = $asignaturas;
    
        return $this;
    }

    /**
     * Remove asignaturas
     *
     * @param Etsi\AppGuiasBundle\Entity\Asignatura $asignaturas
     */
    public function removeAsignatura(\Etsi\AppGuiasBundle\Entity\Asignatura $asignaturas)
    {
        $this->asignaturas->removeElement($asignaturas);
    }

    /**
     * Clear asignatura
     *
     * @return Grado
     */
    public function clearAsignatura()
    {
        $this->asignatura->clear();
        
        return $this;
    }

    /**
     * Get asignaturas
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getAsignaturas()
    {
        $asignaturas = new \Doctrine\Common\Collections\ArrayCollection();

        if(!empty($this->gradoPadre)) {
            $asignaturasPadre = $this->gradoPadre->getAsignaturas();

            foreach($asignaturasPadre as $asignatura)
                $asignaturas[] = $asignatura;
        }
        
        foreach($this->asignaturas as $asignatura)
            $asignaturas[] = $asignatura;

        return $asignaturas;
    }

    /**
     * Add itinerarios
     *
     * @param Etsi\AppGuiasBundle\Entity\Grado $itinerarios
     * @return Grado
     */
    public function addChildren(\Etsi\AppGuiasBundle\Entity\Grado $itinerarios)
    {
        $this->itinerarios[] = $itinerarios;
    
        return $this;
    }

    /**
     * Remove itinerarios
     *
     * @param Etsi\AppGuiasBundle\Entity\Grado $itinerarios
     */
    public function removeChildren(\Etsi\AppGuiasBundle\Entity\Grado $itinerarios)
    {
        $this->itinerarios->removeElement($itinerarios);
    }

    /**
     * Clear itinerario
     *
     * @return Grado
     */
    public function clearItinerario()
    {
        $this->itinerario->clear();
        
        return $this;
    }
    
    /**
     * Get itinerarios
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getChildren()
    {
        return $this->itinerarios;
    }

    /**
     * Set gradoPadre
     *
     * @param Etsi\AppGuiasBundle\Entity\Grado $gradoPadre
     * @return Grado
     */
    public function setGradoPadre(\Etsi\AppGuiasBundle\Entity\Grado $gradoPadre = null)
    {
        $this->gradoPadre = $gradoPadre;
    
        return $this;
    }

    /**
     * Get gradoPadre
     *
     * @return Etsi\AppGuiasBundle\Entity\Grado 
     */
    public function getGradoPadre()
    {
        return $this->gradoPadre;
    }
}