<?php

namespace SON\CategoriaBundle\Form;

use SON\CategoriaBundle\Form\CategoriaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProdutoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nome')
            ->add('unidade')
            //->add('Categoria')
        ;

        $builder->add('Categoria', CategoriaType::class);


    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SON\CategoriaBundle\Entity\Produto'
        ));
    }

    public function getName()
    {
        return 'son_categoriabundle_produtotype';
    }
}
