<?php
namespace Etsi\AppGuiasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="guia")
 * @ORM\Entity
 */
class Guia
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;


    /**
     * @ORM\ManyToOne(targetEntity="Asignatura", inversedBy="guias")
     */
    protected $asignatura;

    /**
     * @ORM\ManyToOne(targetEntity="Profesor", inversedBy="guiasCreadas")
     */
    protected $creador;

    /**
     * @ORM\ManyToMany(targetEntity="Profesor", inversedBy="guias")
     * @ORM\JoinTable(name="guias_profesores")
     */
    protected $profesores;
    
    /**
     * @ORM\Column(type="float")
     */
    protected $creditosTeoricos = 0;

    /**
     * @ORM\Column(type="float")
     */
    protected $creditosPracticosAula = 0;

    /**
     * @ORM\Column(type="float")
     */
    protected $creditosPracticosInformatica = 0;

    /**
     * @ORM\Column(type="float")
     */
    protected $creditosPracticosLaboratorio = 0;

    /**
     * @ORM\Column(type="float")
     */
    protected $creditosPracticosCampo = 0;

    /**
     * @ORM\Column(type="integer")
     */
    protected $estado = 0;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $fechaDeModificacion;

    /**
     * @ORM\Column(type="integer")
     */
    protected $curso;

    /**
     * @ORM\Column(type="text")
     */
    protected $datosEspecificos_1_1 = "";

    /**
     * @ORM\Column(type="text")
     */
    protected $datosEspecificos_1_2 = "";

    /**
     * @ORM\Column(type="text")
     */
    protected $datosEspecificos_2_1 = "";

    /**
     * @ORM\Column(type="text")
     */
    protected $datosEspecificos_2_2 = "";

    /**
     * @ORM\Column(type="text")
     */
    protected $datosEspecificos_3 = "";

    /**
     * @ORM\ManyToMany(targetEntity="Competencia")
     * @ORM\JoinTable(name="guia_competencia_esp")
     */
    private $datosEspecificos_4_1;

    /**
     * @ORM\ManyToMany(targetEntity="Competencia")
     * @ORM\JoinTable(name="guia_competencia_gen")
     */
    private $datosEspecificos_4_2;

    /**
     * @ORM\Column(type="integer")
     */
    protected $datosEspecificos_6_1_1 = 0;

    /**
     * @ORM\Column(type="string")
     */
    protected $datosEspecificos_6_1_2 = "";

    /**
     * @ORM\Column(type="text")
     */
    protected $datosEspecificos_6_2 = "";

    /**
     * @ORM\Column(type="text")
     */
    protected $datosEspecificos_7 = "";

    /**
     * @ORM\Column(type="text")
     */
    protected $datosEspecificos_8_1 = "";

    /**
     * @ORM\Column(type="text")
     */
    protected $datosEspecificos_8_2 = "";

    /**
     * @ORM\Column(type="integer")
     */
    protected $datosEspecificos_9_1_1 = 0;

    /**
     * @ORM\Column(type="string")
     */
    protected $datosEspecificos_9_1_2 = "";

    /**
     * @ORM\Column(type="text")
     */
    protected $datosEspecificos_9_2 = "";

    /**
     * @ORM\OneToMany(targetEntity="Semana", mappedBy="guia")
     */
    protected $datosEspecificos_10;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->profesores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->datosEspecificos_4_1 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->datosEspecificos_4_2 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->datosEspecificos_10 = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set creditosTeoricos
     *
     * @param integer $creditosTeoricos
     * @return Guia
     */
    public function setCreditosTeoricos($creditosTeoricos)
    {
        $this->creditosTeoricos = $creditosTeoricos;
    
        return $this;
    }

    /**
     * Get creditosTeoricos
     *
     * @return integer 
     */
    public function getCreditosTeoricos()
    {
        return $this->creditosTeoricos;
    }

    /**
     * Set creditosPracticosAula
     *
     * @param integer $creditosPracticosAula
     * @return Guia
     */
    public function setCreditosPracticosAula($creditosPracticosAula)
    {
        $this->creditosPracticosAula = $creditosPracticosAula;
    
        return $this;
    }

    /**
     * Get creditosPracticosAula
     *
     * @return integer 
     */
    public function getCreditosPracticosAula()
    {
        return $this->creditosPracticosAula;
    }

    /**
     * Set creditosPracticosInformatica
     *
     * @param integer $creditosPracticosInformatica
     * @return Guia
     */
    public function setCreditosPracticosInformatica($creditosPracticosInformatica)
    {
        $this->creditosPracticosInformatica = $creditosPracticosInformatica;
    
        return $this;
    }

    /**
     * Get creditosPracticosInformatica
     *
     * @return integer 
     */
    public function getCreditosPracticosInformatica()
    {
        return $this->creditosPracticosInformatica;
    }

    /**
     * Set creditosPracticosLaboratorio
     *
     * @param integer $creditosPracticosLaboratorio
     * @return Guia
     */
    public function setCreditosPracticosLaboratorio($creditosPracticosLaboratorio)
    {
        $this->creditosPracticosLaboratorio = $creditosPracticosLaboratorio;
    
        return $this;
    }

    /**
     * Get creditosPracticosLaboratorio
     *
     * @return integer 
     */
    public function getCreditosPracticosLaboratorio()
    {
        return $this->creditosPracticosLaboratorio;
    }

    /**
     * Set creditosPracticosCampo
     *
     * @param integer $creditosPracticosCampo
     * @return Guia
     */
    public function setCreditosPracticosCampo($creditosPracticosCampo)
    {
        $this->creditosPracticosCampo = $creditosPracticosCampo;
    
        return $this;
    }

    /**
     * Get creditosPracticosCampo
     *
     * @return integer 
     */
    public function getCreditosPracticosCampo()
    {
        return $this->creditosPracticosCampo;
    }

    /**
     * Set estado
     *
     * @param integer $estado
     * @return Guia
     */
    public function setEstado($estado)
    {
        if($estado>=0 && $estado<=3)
            $this->estado = $estado;
    
        return $this;
    }

    /**
     * Get estado
     *
     * @return integer 
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set fechaDeModificacion
     *
     * @param \DateTime $fechaDeModificacion
     * @return Guia
     */
    public function setFechaDeModificacion($fechaDeModificacion)
    {
        $this->fechaDeModificacion = $fechaDeModificacion;
    
        return $this;
    }

    /**
     * Get fechaDeModificacion
     *
     * @return \DateTime 
     */
    public function getFechaDeModificacion()
    {
        return $this->fechaDeModificacion;
    }

    /**
     * Set curso
     *
     * @param integer $curso
     * @return Guia
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
     * Set datosEspecificos_1_1
     *
     * @param string $datosEspecificos11
     * @return Guia
     */
    public function setDatosEspecificos_1_1($datosEspecificos11)
    {
        $this->datosEspecificos_1_1 = $datosEspecificos11;
    
        return $this;
    }

    /**
     * Get datosEspecificos_1_1
     *
     * @return string 
     */
    public function getDatosEspecificos_1_1()
    {
        return $this->datosEspecificos_1_1;
    }

    /**
     * Set datosEspecificos_1_2
     *
     * @param string $datosEspecificos12
     * @return Guia
     */
    public function setDatosEspecificos_1_2($datosEspecificos12)
    {
        $this->datosEspecificos_1_2 = $datosEspecificos12;
    
        return $this;
    }

    /**
     * Get datosEspecificos_1_2
     *
     * @return string 
     */
    public function getDatosEspecificos_1_2()
    {
        return $this->datosEspecificos_1_2;
    }

    /**
     * Set datosEspecificos_2_1
     *
     * @param string $datosEspecificos21
     * @return Guia
     */
    public function setDatosEspecificos_2_1($datosEspecificos21)
    {
        $this->datosEspecificos_2_1 = $datosEspecificos21;
    
        return $this;
    }

    /**
     * Get datosEspecificos_2_1
     *
     * @return string 
     */
    public function getDatosEspecificos_2_1()
    {
        return $this->datosEspecificos_2_1;
    }

    /**
     * Set datosEspecificos_2_2
     *
     * @param string $datosEspecificos22
     * @return Guia
     */
    public function setDatosEspecificos_2_2($datosEspecificos22)
    {
        $this->datosEspecificos_2_2 = $datosEspecificos22;
    
        return $this;
    }

    /**
     * Get datosEspecificos_2_2
     *
     * @return string 
     */
    public function getDatosEspecificos_2_2()
    {
        return $this->datosEspecificos_2_2;
    }

    /**
     * Set datosEspecificos_3
     *
     * @param string $datosEspecificos3
     * @return Guia
     */
    public function setDatosEspecificos_3($datosEspecificos3)
    {
        $this->datosEspecificos_3 = $datosEspecificos3;
    
        return $this;
    }

    /**
     * Get datosEspecificos_3
     *
     * @return string 
     */
    public function getDatosEspecificos_3()
    {
        return $this->datosEspecificos_3;
    }

    /**
     * Set datosEspecificos_6_1_1
     *
     * @param integer $datosEspecificos611
     * @return Guia
     */
    public function setDatosEspecificos_6_1_1($datosEspecificos611)
    {
        $this->datosEspecificos_6_1_1 = $datosEspecificos611;
    
        return $this;
    }

    /**
     * Get datosEspecificos_6_1_1
     *
     * @return integer 
     */
    public function getDatosEspecificos_6_1_1()
    {
        return $this->datosEspecificos_6_1_1;
    }

    /**
     * Set datosEspecificos_6_1_2
     *
     * @param string $datosEspecificos612
     * @return Guia
     */
    public function setDatosEspecificos_6_1_2($datosEspecificos612)
    {
        $this->datosEspecificos_6_1_2 = $datosEspecificos612;
    
        return $this;
    }

    /**
     * Get datosEspecificos_6_1_2
     *
     * @return string 
     */
    public function getDatosEspecificos_6_1_2()
    {
        return $this->datosEspecificos_6_1_2;
    }

    /**
     * Set datosEspecificos_6_2
     *
     * @param string $datosEspecificos62
     * @return Guia
     */
    public function setDatosEspecificos_6_2($datosEspecificos62)
    {
        $this->datosEspecificos_6_2 = $datosEspecificos62;
    
        return $this;
    }

    /**
     * Get datosEspecificos_6_2
     *
     * @return string 
     */
    public function getDatosEspecificos_6_2()
    {
        return $this->datosEspecificos_6_2;
    }

    /**
     * Set datosEspecificos_7
     *
     * @param string $datosEspecificos7
     * @return Guia
     */
    public function setDatosEspecificos_7($datosEspecificos7)
    {
        $this->datosEspecificos_7 = $datosEspecificos7;
    
        return $this;
    }

    /**
     * Get datosEspecificos_7
     *
     * @return string 
     */
    public function getDatosEspecificos_7()
    {
        return $this->datosEspecificos_7;
    }

    /**
     * Set datosEspecificos_8_1
     *
     * @param string $datosEspecificos81
     * @return Guia
     */
    public function setDatosEspecificos_8_1($datosEspecificos81)
    {
        $this->datosEspecificos_8_1 = $datosEspecificos81;
    
        return $this;
    }

    /**
     * Get datosEspecificos_8_1
     *
     * @return string 
     */
    public function getDatosEspecificos_8_1()
    {
        return $this->datosEspecificos_8_1;
    }

    /**
     * Set datosEspecificos_8_2
     *
     * @param string $datosEspecificos82
     * @return Guia
     */
    public function setDatosEspecificos_8_2($datosEspecificos82)
    {
        $this->datosEspecificos_8_2 = $datosEspecificos82;
    
        return $this;
    }

    /**
     * Get datosEspecificos_8_2
     *
     * @return string 
     */
    public function getDatosEspecificos_8_2()
    {
        return $this->datosEspecificos_8_2;
    }

    /**
     * Set datosEspecificos_9_1_1
     *
     * @param integer $datosEspecificos911
     * @return Guia
     */
    public function setDatosEspecificos_9_1_1($datosEspecificos911)
    {
        $this->datosEspecificos_9_1_1 = $datosEspecificos911;
    
        return $this;
    }

    /**
     * Get datosEspecificos_9_1_1
     *
     * @return integer 
     */
    public function getDatosEspecificos_9_1_1()
    {
        return $this->datosEspecificos_9_1_1;
    }

    /**
     * Set datosEspecificos_9_1_2
     *
     * @param string $datosEspecificos912
     * @return Guia
     */
    public function setDatosEspecificos_9_1_2($datosEspecificos912)
    {
        $this->datosEspecificos_9_1_2 = $datosEspecificos912;
    
        return $this;
    }

    /**
     * Get datosEspecificos_9_1_2
     *
     * @return string 
     */
    public function getDatosEspecificos_9_1_2()
    {
        return $this->datosEspecificos_9_1_2;
    }

    /**
     * Set datosEspecificos_9_2
     *
     * @param string $datosEspecificos_9_2
     * @return Guia
     */
    public function setDatosEspecificos_9_2($datosEspecificos_9_2)
    {
        $this->datosEspecificos_9_2 = $datosEspecificos_9_2;
    
        return $this;
    }

    /**
     * Get datosEspecificos_9_2
     *
     * @return string 
     */
    public function getDatosEspecificos_9_2()
    {
        return $this->datosEspecificos_9_2;
    }

    /**
     * Set asignatura
     *
     * @param Etsi\AppGuiasBundle\Entity\Asignatura $asignatura
     * @return Guia
     */
    public function setAsignatura(\Etsi\AppGuiasBundle\Entity\Asignatura $asignatura = null)
    {
        $this->asignatura = $asignatura;
    
        return $this;
    }

    /**
     * Get asignatura
     *
     * @return Etsi\AppGuiasBundle\Entity\Asignatura 
     */
    public function getAsignatura()
    {
        return $this->asignatura;
    }

    /**
     * Set creador
     *
     * @param Etsi\AppGuiasBundle\Entity\Profesor $creador
     * @return Guia
     */
    public function setCreador(\Etsi\AppGuiasBundle\Entity\Profesor $creador = null)
    {
        $this->creador = $creador;
    
        return $this;
    }

    /**
     * Get creador
     *
     * @return Etsi\AppGuiasBundle\Entity\Profesor 
     */
    public function getCreador()
    {
        return $this->creador;
    }

    /**
     * Add profesores
     *
     * @param Etsi\AppGuiasBundle\Entity\Profesor $profesores
     * @return Guia
     */
    public function addProfesores(\Etsi\AppGuiasBundle\Entity\Profesor $profesores)
    {
        $this->profesores[] = $profesores;
    
        return $this;
    }

    /**
     * Remove profesores
     *
     * @param Etsi\AppGuiasBundle\Entity\Profesor $profesores
     */
    public function removeProfesores(\Etsi\AppGuiasBundle\Entity\Profesor $profesores)
    {
        $this->profesores->removeElement($profesores);
    }

    /**
     * Clear profesores
     *
     * @return Guia
     */
    public function clearProfesores()
    {
        $this->profesores->clear();
        
        return $this;
    }

    /**
     * Get profesores
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getProfesores()
    {
        return $this->profesores;
    }

    /**
     * Add datosEspecificos_4_1
     *
     * @param Etsi\AppGuiasBundle\Entity\Competencia $datosEspecificos41
     * @return Guia
     */
    public function addDatosEspecificos_4_1(\Etsi\AppGuiasBundle\Entity\Competencia $datosEspecificos41)
    {
        $this->datosEspecificos_4_1[] = $datosEspecificos41;
    
        return $this;
    }

    /**
     * Remove datosEspecificos_4_1
     *
     * @param Etsi\AppGuiasBundle\Entity\Competencia $datosEspecificos41
     */
    public function removeDatosEspecificos_4_1(\Etsi\AppGuiasBundle\Entity\Competencia $datosEspecificos41)
    {
        $this->datosEspecificos_4_1->removeElement($datosEspecificos41);
    }

    /**
     * Clear datosEspecificos_4_1
     *
     * @return Guia
     */
    public function clearDatosEspecificos_4_1()
    {
        $this->datosEspecificos_4_1->clear();
        
        return $this;
    }

    /**
     * Get datosEspecificos_4_1
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getDatosEspecificos_4_1()
    {
        return $this->datosEspecificos_4_1;
    }

    /**
     * Add datosEspecificos_4_2
     *
     * @param Etsi\AppGuiasBundle\Entity\Competencia $datosEspecificos42
     * @return Guia
     */
    public function addDatosEspecificos_4_2(\Etsi\AppGuiasBundle\Entity\Competencia $datosEspecificos42)
    {
        $this->datosEspecificos_4_2[] = $datosEspecificos42;
    
        return $this;
    }

    /**
     * Remove datosEspecificos_4_2
     *
     * @param Etsi\AppGuiasBundle\Entity\Competencia $datosEspecificos42
     */
    public function removeDatosEspecificos_4_2(\Etsi\AppGuiasBundle\Entity\Competencia $datosEspecificos42)
    {
        $this->datosEspecificos_4_2->removeElement($datosEspecificos42);
    }

    /**
     * Clear datosEspecificos_4_2
     *
     * @return Guia
     */
    public function clearDatosEspecificos_4_2()
    {
        $this->datosEspecificos_4_2->clear();
        
        return $this;
    }

    /**
     * Get datosEspecificos_4_2
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getDatosEspecificos_4_2()
    {
        return $this->datosEspecificos_4_2;
    }

    /**
     * Add datosEspecificos_10
     *
     * @param Etsi\AppGuiasBundle\Entity\Semana $datosEspecificos_10
     * @return Guia
     */
    public function addDatosEspecificos_10(\Etsi\AppGuiasBundle\Entity\Semana $datosEspecificos_10)
    {
        $this->datosEspecificos_10[] = $datosEspecificos_10;
    
        return $this;
    }

    /**
     * Remove datosEspecificos_10
     *
     * @param Etsi\AppGuiasBundle\Entity\Semana $datosEspecificos_10
     */
    public function removeDatosEspecificos_10(\Etsi\AppGuiasBundle\Entity\Semana $datosEspecificos_10)
    {
        $this->datosEspecificos_10->removeElement($datosEspecificos_10);
    }

    /**
     * Clear datosEspecificos_10
     *
     * @return Guia
     */
    public function clearDatosEspecificos_10()
    {
        $this->datosEspecificos_10->clear();
        
        return $this;
    }

    /**
     * Get datosEspecificos_10
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getDatosEspecificos_10()
    {
        return $this->datosEspecificos_10;
    }
}