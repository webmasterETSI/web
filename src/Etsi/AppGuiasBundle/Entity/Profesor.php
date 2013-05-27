<?php
namespace Etsi\AppGuiasBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="profesor")
 * @ORM\Entity
 */
class Profesor implements UserInterface, \Serializable
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $nombre;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    protected $email;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $tlf;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $despacho;

    /**
     * @ORM\ManyToMany(targetEntity="Guia", mappedBy="profesores")
     */
    protected $guias;

    /**
     * @ORM\OneToMany(targetEntity="Guia", mappedBy="creador")
     */
    private $guiasCreadas;

    /**
     * @ORM\OneToMany(targetEntity="Asignatura", mappedBy="coordinador")
     */
    private $asignaturasCoordinadas;

    /**
     * @ORM\Column(name="password", type="string", length=255, nullable=true)
     */
    protected $password;

    /**
     * @ORM\Column(name="salt", type="string", length=255, nullable=true)
     */
    protected $salt;

    /**
     * @ORM\ManyToMany(targetEntity="Rol")
     * @ORM\JoinTable(name="profesor_rol",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     * )
     */
    protected $roles;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->guias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->asignaturasCoordinadas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->guiasCreadas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->roles = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return \serialize(array(
            $this->id,
            $this->nombre,
            $this->email,
            $this->tlf,
            $this->salt,
            $this->password
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->nombre,
            $this->email,
            $this->tlf,
            $this->salt,
            $this->password
        ) = \unserialize($serialized);
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set salt
     *
     * @param string $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Add user_roles
     *
     * @param Maycol\BlogBundle\Entity\Rol $userRols
     */
    public function addRole(\Etsi\AppGuiasBundle\Entity\Rol $userRols)
    {
        $this->roles[] = $userRols;
    }

    public function clearRoles()
    {
        $this->roles->clear();
        return $this;
    }
    

    public function setUserRoles($roles) {
        $this->roles = $roles;
    }

    /**
     * Get user_roles
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getUserRoles()
    {
        return $this->roles;
    }

    /**
     * Get roles
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getRoles()
    {
        return $this->roles->toArray(); //IMPORTANTE: el mecanismo de seguridad de Sf2 requiere ésto como un array
    }

    /**
     * Compares this user to another to determine if they are the same.
     *
     * @param UserInterface $user The user
     * @return boolean True if equal, false othwerwise.
     */
    public function equals(UserInterface $user) {
        return md5($this->getUsername()) == md5($user->getUsername());
    }

    /**
     * Erases the user credentials.
     */
    public function eraseCredentials() {

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
     * @return Profesor
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
     * Set email
     *
     * @param string $email
     * @return Profesor
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set tlf
     *
     * @param string $tlf
     * @return Profesor
     */
    public function setTlf($tlf)
    {
        $this->tlf = $tlf;
    
        return $this;
    }

    /**
     * Get tlf
     *
     * @return string 
     */
    public function getTlf()
    {
        return $this->tlf;
    }

    /**
     * Add guias
     *
     * @param Etsi\AppGuiasBundle\Entity\Guia $guias
     * @return Profesor
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
     * @return Profesor
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
     * Add guiasCreadas
     *
     * @param Etsi\AppGuiasBundle\Entity\Guia $guia
     * @return Profesor
     */
    public function addGuiasCreadas(\Etsi\AppGuiasBundle\Entity\Guia $guia)
    {
        $this->guiasCreadas[] = $guia;
    
        return $this;
    }

    /**
     * Remove guiasCreadas
     *
     * @param Etsi\AppGuiasBundle\Entity\Guia $guia
     */
    public function removeGuiasCreadas(\Etsi\AppGuiasBundle\Entity\Guia $guia)
    {
        $this->guiasCreadas->removeElement($guia);
    }

    /**
     * Clear guiasCreadas
     *
     * @return Profesor
     */
    public function clearGuiasCreadas()
    {
        $this->guiasCreadas->clear();
        
        return $this;
    }

    /**
     * Get guiasCreadas
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getGuiasCreadas()
    {
        return $this->guiasCreadas;
    }


    /**
     * Add asignaturasCoordinadas
     *
     * @param Etsi\AppGuiasBundle\Entity\Asignatura $asignatura
     * @return Profesor
     */
    public function addAsignaturasCoordinadas(\Etsi\AppGuiasBundle\Entity\Asignatura $asignatura)
    {
        $this->asignaturasCoordinadas[] = $asignatura;
    
        return $this;
    }

    /**
     * Remove asignaturasCoordinadas
     *
     * @param Etsi\AppGuiasBundle\Entity\Asignatura $asignatura
     */
    public function removeAsignaturasCoordinadas(\Etsi\AppGuiasBundle\Entity\Asignatura $asignatura)
    {
        $this->asignaturasCoordinadas->removeElement($asignatura);
    }

    /**
     * Clear asignaturasCoordinadas
     *
     * @return Profesor
     */
    public function clearAsignaturasCoordinadas()
    {
        $this->asignaturasCoordinadas->clear();
        
        return $this;
    }

    /**
     * Get asignaturasCoordinadas
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getAsignaturasCoordinadas()
    {
        return $this->asignaturasCoordinadas;
    }
}