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
     * @ManyToMany(targetEntity="Grado", inversedBy="asignaturas")
     * @JoinTable(name="asignaturas_grados")
     */
    protected $grados;

    /**
     * @OneToMany(targetEntity="Guia", mappedBy="asignatura")
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
     * @ORM\Column(type="integer")
     */
    protected $codigo;

    /**
     * @ORM\Column(type="string")
     */
    protected $caracter;

    /**
     * @ORM\Column(type="integer")
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
}