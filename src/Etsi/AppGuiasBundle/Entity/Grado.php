<?php
namespace Etsi\AppGuiasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="grado")
 * @ORM\Entity
 */
class Grado
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
     * @ORM\ManyToMany(targetEntity="AsignaturaGrado", mappedBy="grados")
     */
    private $asignaturasGrado;

    /**
     * @ORM\OneToMany(targetEntity="Grado", mappedBy="gradoPadre")
     */
    private $itinerarios;

    /**
     * @ORM\ManyToOne(targetEntity="Grado", inversedBy="itinerarios")
     * @ORM\JoinColumn(name="padre_id", referencedColumnName="id")
     */
    private $gradoPadre;

    /**
     * @ORM\OneToMany(targetEntity="Competencia", mappedBy="grado")
     */
    private $competenciasDeGrado;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->asignaturasGrado = new \Doctrine\Common\Collections\ArrayCollection();
        $this->itinerarios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->competenciasDeGrado = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add asignaturasGrado
     *
     * @param Etsi\AppGuiasBundle\Entity\AsignaturaGrado $asignaturasGrado
     * @return Grado
     */
    public function addAsignaturasGrado(\Etsi\AppGuiasBundle\Entity\AsignaturaGrado $asignaturasGrado)
    {
        $this->asignaturasGrado[] = $asignaturasGrado;
    
        return $this;
    }

    /**
     * Remove asignaturasGrado
     *
     * @param Etsi\AppGuiasBundle\Entity\AsignaturaGrado $asignaturasGrado
     */
    public function removeAsignaturasGrado(\Etsi\AppGuiasBundle\Entity\AsignaturaGrado $asignaturasGrado)
    {
        $this->asignaturasGrado->removeElement($asignaturasGrado);
    }

    /**
     * Clear asignaturaGrado
     *
     * @return Grado
     */
    public function clearAsignaturasGrado()
    {
        $this->asignaturasGrado->clear();
        
        return $this;
    }

    /**
     * Get asignaturasGrado
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getAsignaturasGrado()
    {
        $asignaturasGrado = new \Doctrine\Common\Collections\ArrayCollection();

        if(!empty($this->gradoPadre)) {
            $asignaturasPadre = $this->gradoPadre->getAsignaturasGrado();

            foreach($asignaturasPadre as $asignatura)
                $asignaturasGrado[] = $asignatura;
        }
        
        foreach($this->asignaturasGrado as $asignatura)
            $asignaturasGrado[] = $asignatura;

        return $asignaturasGrado;
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
     * Get itinerarios
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getChildren()
    {
        return $this->itinerarios;
    }

    /**
     * Add competenciasDeGrado
     *
     * @param Etsi\AppGuiasBundle\Entity\Competencia $competencia
     * @return Grado
     */
    public function addcompetenciasDeGrado(\Etsi\AppGuiasBundle\Entity\Competencia $competencia)
    {
        $this->competenciasDeGrado[] = $competencia;
    
        return $this;
    }

    /**
     * Remove competenciasDeGrado
     *
     * @param Etsi\AppGuiasBundle\Entity\Competencia $competencia
     */
    public function removecompetenciasDeGrado(\Etsi\AppGuiasBundle\Entity\Competencia $competencia)
    {
        $this->competenciasDeGrado->removeElement($competencia);
    }
 
    /**
     * Get competenciasDeGrado
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getcompetenciasDeGrado()
    {
        return $this->competenciasDeGrado;

        $competenciasDeGrado = new \Doctrine\Common\Collections\ArrayCollection();

        if(!empty($this->gradoPadre)) {
            $competenciasDeGradoPadre = $this->gradoPadre->getcompetenciasDeGrado();

            foreach($competenciasDeGradoPadre as $competencia)
                $competenciasDeGrado[] = $competencia;
        }
        
        foreach($this->competenciasDeGrado as $competencia)
            $competenciasDeGrado[] = $competencia;

        return $competenciasDeGrado;
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