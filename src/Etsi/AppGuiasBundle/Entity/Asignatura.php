<?php
namespace Etsi\AppGuiasBundle\Entity;

use Doctrine\ORM\Mapping as ORM,
    JMS\Serializer\Annotation\Exclude;


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
     * @ORM\ManyToMany(targetEntity="Grado", inversedBy="asignaturas")
     * @ORM\JoinTable(name="asignaturas_grados")
     */
    protected $grados;

    /**
     * @ORM\OneToMany(targetEntity="Guia", mappedBy="asignatura")
     *
     * @Exclude
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
     * @ORM\Column(type="integer", unique=true)
     */
    protected $codigo;

    /**
     * @ORM\Column(type="string")
     */
    protected $caracter;

    /**
     * @ORM\Column(type="float")
     */
    protected $creditos;

    /**
     * @ORM\Column(type="string")
     */
    protected $departamento;

    /**
     * @ORM\Column(type="string")
     */
    protected $area;

    /**
     * @ORM\Column(type="integer")
     */
    protected $curso;

    /**
     * @ORM\Column(type="integer")
     */
    protected $cuatrimestre;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->grados = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set departamento
     *
     * @param string $departamento
     * @return Asignatura
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
     * Set area
     *
     * @param string $area
     * @return Asignatura
     */
    public function setArea($area)
    {
        $this->area = $area;
    
        return $this;
    }

    /**
     * Get area
     *
     * @return string 
     */
    public function getArea()
    {
        return $this->area;
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
     * Add grados
     *
     * @param Etsi\AppGuiasBundle\Entity\Grado $grados
     * @return Asignatura
     */
    public function addGrado(\Etsi\AppGuiasBundle\Entity\Grado $grados)
    {
        $this->grados[] = $grados;
    
        return $this;
    }

    /**
     * Remove grados
     *
     * @param Etsi\AppGuiasBundle\Entity\Grado $grados
     */
    public function removeGrado(\Etsi\AppGuiasBundle\Entity\Grado $grados)
    {
        $this->grados->removeElement($grados);
    }

    /**
     * Clear grado
     *
     * @return Asignatura
     */
    public function clearGrado()
    {
        $this->grados->clear();

        return $this;
    }

    /**
     * Get grados
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getGrados()
    {
        return $this->grados;
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
}