<?php
namespace Etsi\AppGuiasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Table(name="asignatura_grado")
 * @ORM\Entity
 */
class AsignaturaGrado
{
    /**
     * @ORM\Column(type="integer")
     */
    protected $codigo;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Asignatura", inversedBy="enGrados")
     */
    protected $asignatura;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Grado", inversedBy="asignaturaGrado")
     */
    protected $grado;

    /**
     * Set codigo
     *
     * @param integer $codigo
     * @return AsignaturaGrado
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
     * Set asignatura
     *
     * @param \Etsi\AppGuiasBundle\Entity\Asignatura $asignatura
     * @return AsignaturaGrado
     */
    public function setAsignatura(\Etsi\AppGuiasBundle\Entity\Asignatura $asignatura)
    {
        $this->asignatura = $asignatura;
    
        return $this;
    }

    /**
     * Get asignatura
     *
     * @return \Etsi\AppGuiasBundle\Entity\Asignatura 
     */
    public function getAsignatura()
    {
        return $this->asignatura;
    }

    /**
     * Set grado
     *
     * @param \Etsi\AppGuiasBundle\Entity\Grado $grado
     * @return AsignaturaGrado
     */
    public function setGrado(\Etsi\AppGuiasBundle\Entity\Grado $grado)
    {
        $this->grado = $grado;
    
        return $this;
    }

    /**
     * Get grado
     *
     * @return \Etsi\AppGuiasBundle\Entity\Grado 
     */
    public function getGrado()
    {
        return $this->grado;
    }
}