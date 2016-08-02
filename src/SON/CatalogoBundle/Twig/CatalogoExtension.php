<?php

namespace SON\CatalogoBundle\Twig;


class CatalogoExtension extends \Twig_Extension
{

    public function getFilters()
    {
        return array(
            'bold' => new \Twig_Filter_Method($this, 'bold')
        );
    }

    public function bold($str)
    {
        return "<b>{$str}</b>";
    }

    public function getName()
    {
        return "catalogo";
    }

}