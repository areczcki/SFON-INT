<?php

namespace SON\CatalogoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SON\CatalogoBundle\Entity\Catalogo;
use Symfony\Component\BrowserKit\Response;
use SON\CatalogoBundle\Reporting\CatalogoReportManager;

class RelatorioController extends Controller
{
 	
	/**
	 * @Route("/catalogo/relatorio/catalogos.{_format}", name="catalogo_relatorio", defaults={"_format"="csv"})
	 */
    public function catalogosAction()
    {
    	try {
	 		
    		$catalogoReportManager = $this->container->get('son_catalogo.reporting');
    		//$catalogoReportManager = new CatalogoReportManager($this->getDoctrine()->getManager());
    		$content = $catalogoReportManager->getAllCatalogos();
	    	
	 		echo"<pre/>";
	 		print_r($content);
	 		
	 		$response = new Response($content);
	 		$response->headers->set("Content-type","text/csv");
	    	
	    	return $response;
    	} catch (Exception $e) {
    		print_r($e->getMessage());exit;
    	}
    }
    
}
