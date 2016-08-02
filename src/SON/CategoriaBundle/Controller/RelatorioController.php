<?php

namespace SON\CategoriaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SON\CategoriaBundle\Entity\Categoria;
use Symfony\Component\BrowserKit\Response;
use SON\CatalogoBundle\Reporting\CatalogoReportManager;

class RelatorioController extends Controller
{
 	
	/**
	 * @Route("/categoria/relatorio/categorias.{_format}", name="categoria_relatorio", defaults={"_format"="csv"})
	 */
    public function categoriasAction()
    {
    	try {
	 		
    		$categoriaReportManager = $this->container->get('categoria_report_manager');
    		//$catalogoReportManager = new CatalogoReportManager($this->getDoctrine()->getManager());
    		$content = $categoriaReportManager->getAllCategorias();
	    	
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
