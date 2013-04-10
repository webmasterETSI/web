<?php
namespace Etsi\AppGuiasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="competencia")
 * @ORM\Entity
 */
class Competencia
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
    protected $codigo;

    /**
     * @ORM\Column(type="string")
     */
    protected $nombre;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $transversal;

    /**
     * @ORM\ManyToOne(targetEntity="Grado", inversedBy="competenciasDeGrado")
     */
    protected $grado;

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
     * Set codigo
     *
     * @param string $codigo
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
     * @return string 
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Competencia
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
     * Set transversal
     *
     * @param string $transversal
     * @return Competencia
     */
    public function setTransversal($transversal)
    {
        $this->transversal = $transversal;
    
        return $this;
    }

    /**
     * Get transversal
     *
     * @return boolean 
     */
    public function getTransversal()
    {
        return $this->transversal;
    }

    /**
     * Set grado
     *
     * @param Etsi\AppGuiasBundle\Entity\Grado $grado
     * @return Grado
     */
    public function setGrado(\Etsi\AppGuiasBundle\Entity\Grado $grado = null)
    {
        $this->grado = $grado;
    
        return $this;
    }

    /**
     * Get grado
     *
     * @return Etsi\AppGuiasBundle\Entity\Grado 
     */
    public function getGrado()
    {
        return $this->grado;
    }
}