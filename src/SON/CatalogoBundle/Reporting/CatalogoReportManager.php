<?php

namespace SON\CatalogoBundle\Reporting;
use Doctrine\ORM\EntityManager;
use Monolog\Logger;

class CatalogoReportManager {
	
	private $em;
	private $logger;
	
	public function __construct(EntityManager $em)
	{
		$this->em = $em;		
	}
	
	public function getAllCatalogos(){
		$this->logInfo("Opa estamos logando!!! Fazendo o download do arquivo!");
		$catalogos = $this->em->getRepository('CatalogoBundle:Catalogo')->getRelatorioCatalogos();
		
		$rows = array();
		foreach ($catalogos as $catalogo){
			/** @var Catalogo */
			//var_dump($catalogo->getLancamento()->format('Y-m-d h:i:s'));exit;
			$data = array($catalogo->getId(), $catalogo->getName(), $catalogo->getLancamento()->format('Y-m-d h:i:s'));
			$rows[] = implode(",", $data);
		}
		
		return implode("\n", $rows);
	}
	
	public function setLogger(Logger $logger){
		$this->logger = $logger;
	}
	
	private function logInfo($msg){
		if($this->logger){
			$this->logger->info($msg);
		}
	}
	
}