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
     * @OneToMany(targetEntity="Asignatura", mappedBy="grado")
     */
    private $asignaturas;

    /**
     * @OneToMany(targetEntity="Grado", mappedBy="gradoPadre")
     */
    private $children;

    /**
     * @ManyToOne(targetEntity="Grado", inversedBy="itinerarios")
     * @JoinColumn(name="padre_id", referencedColumnName="id")
     */
    private $gradoPadre;
}