<?php

namespace SON\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegisterFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("username", "text", array(
                'required' => false,
                'pattern' => '[a-zA-Z0-9]+',
                'attr' => array('class' => 'campo_user')
            ))
            ->add("email", "text")
            ->add("plainPassword", "repeated",  array(
                "type" => "password"
        ));
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'SON\UserBundle\Entity\User'
        );
    }

    public function getName()
    {
        return 'son_userbundle_usertype';
    }
}
