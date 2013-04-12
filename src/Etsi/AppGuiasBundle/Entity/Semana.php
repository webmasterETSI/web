<?php
namespace Etsi\AppGuiasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="semana")
 * @ORM\Entity
 */
class Semana
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Guia", inversedBy="datosEspecificos_9_2")
     */
    protected $guia;


    /**
     * @ORM\Column(type="integer")
     */
    protected $numeroSemana;
    
    /**
     * @ORM\Column(type="float")
     */
    protected $horasGruposGrandes;
    
    /**
     * @ORM\Column(type="float")
     */
    protected $horasGruposReducidosAula;
    
    /**
     * @ORM\Column(type="float")
     */
    protected $horasGruposReducidosInformatica;
    
    /**
     * @ORM\Column(type="float")
     */
    protected $horasGruposReducidosLaboratorio;
    
    /**
     * @ORM\Column(type="float")
     */
    protected $horasGruposReducidosCampo;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $examen;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $observaciones;

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
     * Set numeroSemana
     *
     * @param integer $numeroSemana
     * @return Semana
     */
    public function setNumeroSemana($numeroSemana)
    {
        $this->numeroSemana = $numeroSemana;
    
        return $this;
    }

    /**
     * Get numeroSemana
     *
     * @return integer 
     */
    public function getNumeroSemana()
    {
        return $this->numeroSemana;
    }

    /**
     * Set horasGruposGrandes
     *
     * @param integer $horasGruposGrandes
     * @return Semana
     */
    public function setHorasGruposGrandes($horasGruposGrandes)
    {
        $this->horasGruposGrandes = $horasGruposGrandes;
    
        return $this;
    }

    /**
     * Get horasGruposGrandes
     *
     * @return integer 
     */
    public function getHorasGruposGrandes()
    {
        return $this->horasGruposGrandes;
    }

    /**
     * Set horasGruposReducidosAula
     *
     * @param integer $horasGruposReducidosAula
     * @return Semana
     */
    public function setHorasGruposReducidosAula($horasGruposReducidosAula)
    {
        $this->horasGruposReducidosAula = $horasGruposReducidosAula;
    
        return $this;
    }

    /**
     * Get horasGruposReducidosAula
     *
     * @return integer 
     */
    public function getHorasGruposReducidosAula()
    {
        return $this->horasGruposReducidosAula;
    }

    /**
     * Set horasGruposReducidosInformatica
     *
     * @param integer $horasGruposReducidosInformatica
     * @return Semana
     */
    public function setHorasGruposReducidosInformatica($horasGruposReducidosInformatica)
    {
        $this->horasGruposReducidosInformatica = $horasGruposReducidosInformatica;
    
        return $this;
    }

    /**
     * Get horasGruposReducidosInformatica
     *
     * @return integer 
     */
    public function getHorasGruposReducidosInformatica()
    {
        return $this->horasGruposReducidosInformatica;
    }

    /**
     * Set horasGruposReducidosLaboratorio
     *
     * @param integer $horasGruposReducidosLaboratorio
     * @return Semana
     */
    public function setHorasGruposReducidosLaboratorio($horasGruposReducidosLaboratorio)
    {
        $this->horasGruposReducidosLaboratorio = $horasGruposReducidosLaboratorio;
    
        return $this;
    }

    /**
     * Get horasGruposReducidosLaboratorio
     *
     * @return integer 
     */
    public function getHorasGruposReducidosLaboratorio()
    {
        return $this->horasGruposReducidosLaboratorio;
    }

    /**
     * Set horasGruposReducidosCampo
     *
     * @param integer $horasGruposReducidosCampo
     * @return Semana
     */
    public function setHorasGruposReducidosCampo($horasGruposReducidosCampo)
    {
        $this->horasGruposReducidosCampo = $horasGruposReducidosCampo;
    
        return $this;
    }

    /**
     * Get horasGruposReducidosCampo
     *
     * @return integer 
     */
    public function getHorasGruposReducidosCampo()
    {
        return $this->horasGruposReducidosCampo;
    }

    /**
     * Set examen
     *
     * @param string $examen
     * @return Semana
     */
    public function setExamen($examen)
    {
        $this->examen = $examen;
    
        return $this;
    }

    /**
     * Get examen
     *
     * @return string 
     */
    public function getExamen()
    {
        return $this->examen;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     * @return Semana
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;
    
        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string 
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Set guia
     *
     * @param Etsi\AppGuiasBundle\Entity\Guia $guia
     * @return Semana
     */
    public function setGuia(\Etsi\AppGuiasBundle\Entity\Guia $guia = null)
    {
        $this->guia = $guia;
    
        return $this;
    }

    /**
     * Get guia
     *
     * @return Etsi\AppGuiasBundle\Entity\Guia 
     */
    public function getGuia()
    {
        return $this->guia;
    }
}