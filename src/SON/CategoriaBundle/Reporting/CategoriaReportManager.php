<?php

namespace SON\CategoriaBundle\Reporting;
use Doctrine\ORM\EntityManager;
use SON\CategoriaBundle\Entity\Categoria;

class CategoriaReportManager {
	
	private $em;
	
	public function __construct($em)
	{
		$this->em = $em;		
	}
	
	public function getAllCategorias(){
		
		$categorias = $this->em->getRepository('CategoriaBundle:Categoria')->getRelatorioCategorias();
		
		$rows = array();
		foreach ($categorias as $c){
			$data = array($c->getId(), $c->getNome());
			$rows[] = implode(",", $data);
		}
		
		return implode("\n", $rows);
	}
	
}