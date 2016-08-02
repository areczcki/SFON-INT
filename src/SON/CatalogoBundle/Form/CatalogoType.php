<?php

namespace SON\CatalogoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CatalogoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('descricao')
            ->add('lancamento')
            ->add('imageName')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SON\CatalogoBundle\Entity\Catalogo'
        ));
    }

    public function getName()
    {
        return 'son_catalogobundle_catalogotype';
    }
}
