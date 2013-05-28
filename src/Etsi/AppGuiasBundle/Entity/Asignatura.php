<?php
namespace Etsi\AppGuiasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Table(name="asignatura")
 * @ORM\Entity
 */
class Asignatura
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="AsignaturaGrado", mappedBy="asignatura")
     */
    private $enGrados;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $comentario;

    /**
     * @ORM\OneToMany(targetEntity="Guia", mappedBy="asignatura")
     */
    private $guias;

    /**
     * @ORM\Column(type="string")
     */
    protected $nombre;

    /**
     * @ORM\Column(type="string")
     */
    protected $nombreI;

    /**
     * @ORM\Column(type="string")
     */
    protected $caracter;

    /**
     * @ORM\Column(type="float")
     */
    protected $creditos;

    /**
     * @ORM\ManyToMany(targetEntity="Area", inversedBy="asignaturas")
     * @ORM\JoinTable(name="asignaturas_areas")
     */
    protected $areas;

    /**
     * @ORM\Column(type="integer")
     */
    protected $curso;

    /**
     * @ORM\Column(type="integer")
     */
    protected $cuatrimestre;

    /**
     * @ORM\ManyToOne(targetEntity="Profesor", inversedBy="asignaturasCoordinadas")
     */
    protected $coordinador;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->enGrados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->guias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->areas = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Asignatura
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
     * Set nombreI
     *
     * @param string $nombreI
     * @return Asignatura
     */
    public function setNombreI($nombreI)
    {
        $this->nombreI = $nombreI;
    
        return $this;
    }

    /**
     * Get nombreI
     *
     * @return string 
     */
    public function getNombreI()
    {
        return $this->nombreI;
    }

    /**
     * Set codigo
     *
     * @param integer $codigo
     * @return Asignatura
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    
        return $this;
    }

    /**
     * Get codigo
     *
     * @return integer 
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set comentario
     *
     * @param string $comentario
     * @return Asignatura
     */
    public function setComentario($comentario)
    {
        $this->comentario = $comentario;
    
        return $this;
    }

    /**
     * Get comentario
     *
     * @return string 
     */
    public function getComentario()
    {
        return $this->comentario;
    }

    /**
     * Set caracter
     *
     * @param string $caracter
     * @return Asignatura
     */
    public function setCaracter($caracter)
    {
        $this->caracter = $caracter;
    
        return $this;
    }

    /**
     * Get caracter
     *
     * @return string 
     */
    public function getCaracter()
    {
        return $this->caracter;
    }

    /**
     * Set creditos
     *
     * @param float $creditos
     * @return Asignatura
     */
    public function setCreditos($creditos)
    {
        $this->creditos = $creditos;
    
        return $this;
    }

    /**
     * Get creditos
     *
     * @return float 
     */
    public function getCreditos()
    {
        return $this->creditos;
    }

    /**
     * Set curso
     *
     * @param integer $curso
     * @return Asignatura
     */
    public function setCurso($curso)
    {
        $this->curso = $curso;
    
        return $this;
    }

    /**
     * Get curso
     *
     * @return integer 
     */
    public function getCurso()
    {
        return $this->curso;
    }

    /**
     * Set cuatrimestre
     *
     * @param integer $cuatrimestre
     * @return Asignatura
     */
    public function setCuatrimestre($cuatrimestre)
    {
        $this->cuatrimestre = $cuatrimestre;
    
        return $this;
    }

    /**
     * Get cuatrimestre
     *
     * @return integer 
     */
    public function getCuatrimestre()
    {
        return $this->cuatrimestre;
    }

    /**
     * Add guias
     *
     * @param Etsi\AppGuiasBundle\Entity\Guia $guias
     * @return Asignatura
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
     * @return Asignatura
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

    /**
     * Add enGrados
     *
     * @param Etsi\AppGuiasBundle\Entity\AsignaturaGrado $enGrados
     * @return Asignatura
     */
    public function addEnGrados(\Etsi\AppGuiasBundle\Entity\AsignaturaGrado $enGrados)
    {
        $this->enGrados[] = $enGrados;
    
        return $this;
    }

    /**
     * Remove enGrados
     *
     * @param Etsi\AppGuiasBundle\Entity\AsignaturaGrado $enGrados
     */
    public function removeEnGrados(\Etsi\AppGuiasBundle\Entity\AsignaturaGrado $enGrados)
    {
        $this->enGrados->removeElement($enGrados);
    }

    /**
     * Clear enGrados
     *
     * @return Asignatura
     */
    public function clearEnGrados()
    {
        $this->enGrados->clear();
        
        return $this;
    }

    /**
     * Get enGrados
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getEnGrados()
    {
        return $this->enGrados;
    }

    /**
     * Add areas
     *
     * @param Etsi\AppGuiasBundle\Entity\Area $areas
     * @return Asignatura
     */
    public function addArea(\Etsi\AppGuiasBundle\Entity\Area $areas)
    {
        $this->areas[] = $areas;
    
        return $this;
    }

    /**
     * Remove areas
     *
     * @param Etsi\AppGuiasBundle\Entity\Area $areas
     */
    public function removeArea(\Etsi\AppGuiasBundle\Entity\Area $areas)
    {
        $this->areas->removeElement($areas);
    }

    /**
     * Clear areas
     *
     * @return Asignatura
     */
    public function clearAreas()
    {
        $this->areas->clear();

        return $this;
    }

    /**
     * Get areas
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getAreas()
    {
        return $this->areas;
    }

    /**
     * Set coordinador
     *
     * @param Etsi\AppGuiasBundle\Entity\Profesor $coordinador
     * @return Asignatura
     */
    public function setCoordinador(\Etsi\AppGuiasBundle\Entity\Profesor $coordinador = null)
    {
        $this->coordinador = $coordinador;
    
        return $this;
    }

    /**
     * Get coordinador
     *
     * @return Etsi\AppGuiasBundle\Entity\Profesor 
     */
    public function getCoordinador()
    {
        return $this->coordinador;
    }

}