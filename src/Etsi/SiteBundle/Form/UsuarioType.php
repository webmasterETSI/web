<?php
namespace Etsi\SiteBundle\Form;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface;

use Doctrine\ORM\EntityRepository;

use Etsi\SiteBundle\Entity\Usuario,
    Etsi\SiteBundle\Entity\Seccion;

class UsuarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('id', 'hidden');
        $builder->add('nick', 'text');
        $builder->add('pass', 'password');
        $builder->add('imagen', 'text', array('required' => false));
    }

    public function getName()
    {
        return 'usuario';
    }
}