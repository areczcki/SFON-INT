<?php

namespace SON\CategoriaBundle\Service;

use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


/**
 * Categoria controller.
 *
 */
class AutenticacaoService
{

    /** @var  SecurityContext */
    private $securityContext;

    public function validarPermissao(){
        echo"entrou";exit;
    }
}