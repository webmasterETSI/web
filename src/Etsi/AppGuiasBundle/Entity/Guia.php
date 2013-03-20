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
     * @JoinTable(name="guias_profesores")
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
     * @ORM\Column(type="integer")
     */
    protected $version;

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
     * @ManyToMany(targetEntity="Competencia")
     * @JoinTable(name="guia_competencia_esp")
     */
    private $datosEspecificos_4_1;

    /**
     * @ManyToMany(targetEntity="Competencia")
     * @JoinTable(name="guia_competencia_gen")
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
     * @OneToMany(targetEntity="Semana", mappedBy="guia")
     */
    protected $datosEspecificos_9_2;

    /**
     * @ORM\Column(type="text")
     */
    protected $datosEspecificos_10;
}