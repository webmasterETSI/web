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
     * @ORM\ManyToMany(targetEntity="Profesor", mappedBy="guias")
     * @ORM\JoinTable(name="guias_profesores")
     */
    protected $profesores;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $creditosTeoricos;

    /**
     * @ORM\Column(type="integer")
     */
    protected $creditosPracticosAula;

    /**
     * @ORM\Column(type="integer")
     */
    protected $creditosPracticosInformatica;

    /**
     * @ORM\Column(type="integer")
     */
    protected $creditosPracticosLaboratorio;

    /**
     * @ORM\Column(type="integer")
     */
    protected $creditosPracticosCampo;

    /**
     * @ORM\Column(type="integer")
     */
    protected $estado;

    /**
     * @ORM\Column(type="date")
     */
    protected $fechaDeModificacion;

    /**
     * @ORM\Column(type="text")
     */
    protected $datosEspecificos_1_1;

    /**
     * @ORM\Column(type="text")
     */
    protected $datosEspecificos_1_2;

    /**
     * @ORM\Column(type="text")
     */
    protected $datosEspecificos_2_1;

    /**
     * @ORM\Column(type="text")
     */
    protected $datosEspecificos_2_2;

    /**
     * @ORM\Column(type="text")
     */
    protected $datosEspecificos_3;

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
    protected $datosEspecificos_6_1_1;

    /**
     * @ORM\Column(type="string")
     */
    protected $datosEspecificos_6_1_2;

    /**
     * @ORM\Column(type="text")
     */
    protected $datosEspecificos_6_2;

    /**
     * @ORM\Column(type="text")
     */
    protected $datosEspecificos_7;

    /**
     * @ORM\Column(type="text")
     */
    protected $datosEspecificos_8_1;

    /**
     * @ORM\Column(type="text")
     */
    protected $datosEspecificos_8_2;

    /**
     * @ORM\Column(type="integer")
     */
    protected $datosEspecificos_9_1_1;

    /**
     * @ORM\Column(type="string")
     */
    protected $datosEspecificos_9_1_2;

    /**
     * @ORM\OneToMany(targetEntity="Semana", mappedBy="guia")
     */
    protected $datosEspecificos_9_2;

    /**
     * @ORM\Column(type="text")
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
        $this->datosEspecificos_9_2 = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set datosEspecificos_1_1
     *
     * @param string $datosEspecificos11
     * @return Guia
     */
    public function setDatosEspecificos11($datosEspecificos11)
    {
        $this->datosEspecificos_1_1 = $datosEspecificos11;
    
        return $this;
    }

    /**
     * Get datosEspecificos_1_1
     *
     * @return string 
     */
    public function getDatosEspecificos11()
    {
        return $this->datosEspecificos_1_1;
    }

    /**
     * Set datosEspecificos_1_2
     *
     * @param string $datosEspecificos12
     * @return Guia
     */
    public function setDatosEspecificos12($datosEspecificos12)
    {
        $this->datosEspecificos_1_2 = $datosEspecificos12;
    
        return $this;
    }

    /**
     * Get datosEspecificos_1_2
     *
     * @return string 
     */
    public function getDatosEspecificos12()
    {
        return $this->datosEspecificos_1_2;
    }

    /**
     * Set datosEspecificos_2_1
     *
     * @param string $datosEspecificos21
     * @return Guia
     */
    public function setDatosEspecificos21($datosEspecificos21)
    {
        $this->datosEspecificos_2_1 = $datosEspecificos21;
    
        return $this;
    }

    /**
     * Get datosEspecificos_2_1
     *
     * @return string 
     */
    public function getDatosEspecificos21()
    {
        return $this->datosEspecificos_2_1;
    }

    /**
     * Set datosEspecificos_2_2
     *
     * @param string $datosEspecificos22
     * @return Guia
     */
    public function setDatosEspecificos22($datosEspecificos22)
    {
        $this->datosEspecificos_2_2 = $datosEspecificos22;
    
        return $this;
    }

    /**
     * Get datosEspecificos_2_2
     *
     * @return string 
     */
    public function getDatosEspecificos22()
    {
        return $this->datosEspecificos_2_2;
    }

    /**
     * Set datosEspecificos_3
     *
     * @param string $datosEspecificos3
     * @return Guia
     */
    public function setDatosEspecificos3($datosEspecificos3)
    {
        $this->datosEspecificos_3 = $datosEspecificos3;
    
        return $this;
    }

    /**
     * Get datosEspecificos_3
     *
     * @return string 
     */
    public function getDatosEspecificos3()
    {
        return $this->datosEspecificos_3;
    }

    /**
     * Set datosEspecificos_6_1_1
     *
     * @param integer $datosEspecificos611
     * @return Guia
     */
    public function setDatosEspecificos611($datosEspecificos611)
    {
        $this->datosEspecificos_6_1_1 = $datosEspecificos611;
    
        return $this;
    }

    /**
     * Get datosEspecificos_6_1_1
     *
     * @return integer 
     */
    public function getDatosEspecificos611()
    {
        return $this->datosEspecificos_6_1_1;
    }

    /**
     * Set datosEspecificos_6_1_2
     *
     * @param string $datosEspecificos612
     * @return Guia
     */
    public function setDatosEspecificos612($datosEspecificos612)
    {
        $this->datosEspecificos_6_1_2 = $datosEspecificos612;
    
        return $this;
    }

    /**
     * Get datosEspecificos_6_1_2
     *
     * @return string 
     */
    public function getDatosEspecificos612()
    {
        return $this->datosEspecificos_6_1_2;
    }

    /**
     * Set datosEspecificos_6_2
     *
     * @param string $datosEspecificos62
     * @return Guia
     */
    public function setDatosEspecificos62($datosEspecificos62)
    {
        $this->datosEspecificos_6_2 = $datosEspecificos62;
    
        return $this;
    }

    /**
     * Get datosEspecificos_6_2
     *
     * @return string 
     */
    public function getDatosEspecificos62()
    {
        return $this->datosEspecificos_6_2;
    }

    /**
     * Set datosEspecificos_7
     *
     * @param string $datosEspecificos7
     * @return Guia
     */
    public function setDatosEspecificos7($datosEspecificos7)
    {
        $this->datosEspecificos_7 = $datosEspecificos7;
    
        return $this;
    }

    /**
     * Get datosEspecificos_7
     *
     * @return string 
     */
    public function getDatosEspecificos7()
    {
        return $this->datosEspecificos_7;
    }

    /**
     * Set datosEspecificos_8_1
     *
     * @param string $datosEspecificos81
     * @return Guia
     */
    public function setDatosEspecificos81($datosEspecificos81)
    {
        $this->datosEspecificos_8_1 = $datosEspecificos81;
    
        return $this;
    }

    /**
     * Get datosEspecificos_8_1
     *
     * @return string 
     */
    public function getDatosEspecificos81()
    {
        return $this->datosEspecificos_8_1;
    }

    /**
     * Set datosEspecificos_8_2
     *
     * @param string $datosEspecificos82
     * @return Guia
     */
    public function setDatosEspecificos82($datosEspecificos82)
    {
        $this->datosEspecificos_8_2 = $datosEspecificos82;
    
        return $this;
    }

    /**
     * Get datosEspecificos_8_2
     *
     * @return string 
     */
    public function getDatosEspecificos82()
    {
        return $this->datosEspecificos_8_2;
    }

    /**
     * Set datosEspecificos_9_1_1
     *
     * @param integer $datosEspecificos911
     * @return Guia
     */
    public function setDatosEspecificos911($datosEspecificos911)
    {
        $this->datosEspecificos_9_1_1 = $datosEspecificos911;
    
        return $this;
    }

    /**
     * Get datosEspecificos_9_1_1
     *
     * @return integer 
     */
    public function getDatosEspecificos911()
    {
        return $this->datosEspecificos_9_1_1;
    }

    /**
     * Set datosEspecificos_9_1_2
     *
     * @param string $datosEspecificos912
     * @return Guia
     */
    public function setDatosEspecificos912($datosEspecificos912)
    {
        $this->datosEspecificos_9_1_2 = $datosEspecificos912;
    
        return $this;
    }

    /**
     * Get datosEspecificos_9_1_2
     *
     * @return string 
     */
    public function getDatosEspecificos912()
    {
        return $this->datosEspecificos_9_1_2;
    }

    /**
     * Set datosEspecificos_10
     *
     * @param string $datosEspecificos10
     * @return Guia
     */
    public function setDatosEspecificos10($datosEspecificos10)
    {
        $this->datosEspecificos_10 = $datosEspecificos10;
    
        return $this;
    }

    /**
     * Get datosEspecificos_10
     *
     * @return string 
     */
    public function getDatosEspecificos10()
    {
        return $this->datosEspecificos_10;
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
     * Add profesores
     *
     * @param Etsi\AppGuiasBundle\Entity\Profesor $profesores
     * @return Guia
     */
    public function addProfesore(\Etsi\AppGuiasBundle\Entity\Profesor $profesores)
    {
        $this->profesores[] = $profesores;
    
        return $this;
    }

    /**
     * Remove profesores
     *
     * @param Etsi\AppGuiasBundle\Entity\Profesor $profesores
     */
    public function removeProfesore(\Etsi\AppGuiasBundle\Entity\Profesor $profesores)
    {
        $this->profesores->removeElement($profesores);
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
    public function addDatosEspecificos41(\Etsi\AppGuiasBundle\Entity\Competencia $datosEspecificos41)
    {
        $this->datosEspecificos_4_1[] = $datosEspecificos41;
    
        return $this;
    }

    /**
     * Remove datosEspecificos_4_1
     *
     * @param Etsi\AppGuiasBundle\Entity\Competencia $datosEspecificos41
     */
    public function removeDatosEspecificos41(\Etsi\AppGuiasBundle\Entity\Competencia $datosEspecificos41)
    {
        $this->datosEspecificos_4_1->removeElement($datosEspecificos41);
    }

    /**
     * Get datosEspecificos_4_1
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getDatosEspecificos41()
    {
        return $this->datosEspecificos_4_1;
    }

    /**
     * Add datosEspecificos_4_2
     *
     * @param Etsi\AppGuiasBundle\Entity\Competencia $datosEspecificos42
     * @return Guia
     */
    public function addDatosEspecificos42(\Etsi\AppGuiasBundle\Entity\Competencia $datosEspecificos42)
    {
        $this->datosEspecificos_4_2[] = $datosEspecificos42;
    
        return $this;
    }

    /**
     * Remove datosEspecificos_4_2
     *
     * @param Etsi\AppGuiasBundle\Entity\Competencia $datosEspecificos42
     */
    public function removeDatosEspecificos42(\Etsi\AppGuiasBundle\Entity\Competencia $datosEspecificos42)
    {
        $this->datosEspecificos_4_2->removeElement($datosEspecificos42);
    }

    /**
     * Get datosEspecificos_4_2
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getDatosEspecificos42()
    {
        return $this->datosEspecificos_4_2;
    }

    /**
     * Add datosEspecificos_9_2
     *
     * @param Etsi\AppGuiasBundle\Entity\Semana $datosEspecificos92
     * @return Guia
     */
    public function addDatosEspecificos92(\Etsi\AppGuiasBundle\Entity\Semana $datosEspecificos92)
    {
        $this->datosEspecificos_9_2[] = $datosEspecificos92;
    
        return $this;
    }

    /**
     * Remove datosEspecificos_9_2
     *
     * @param Etsi\AppGuiasBundle\Entity\Semana $datosEspecificos92
     */
    public function removeDatosEspecificos92(\Etsi\AppGuiasBundle\Entity\Semana $datosEspecificos92)
    {
        $this->datosEspecificos_9_2->removeElement($datosEspecificos92);
    }

    /**
     * Get datosEspecificos_9_2
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getDatosEspecificos92()
    {
        return $this->datosEspecificos_9_2;
    }
}