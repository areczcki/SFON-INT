<?php

namespace SON\CategoriaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use stdClass;

class DefaultController extends Controller
{
    /**
     * 1 - Crie um bundle chamado Categoria e crie uma rota /categorias e adicione na sua action
     * um array de categorias de produtos pré-definidas. Ao acessar o /categorias deve ser listado
     * td conteúdo deste array.
     */
    public function indexAction()
    {
    	$categoriaReportManager = $this->container->get('categoria_report_manager');
    	$content = $categoriaReportManager->getAllCategorias();
    	var_dump($content);
    	exit;
    	
        //$categorias = $this->listarCategoriasObj();
        return $this->render('CategoriaBundle:Default:exercicio1.html.twig',array('categorias' => $categorias));
    }

    public function buscarCategoriaMaisProdutoAction($nomeCategoria, $nomeProduto)
    {
        $nomeCategoria  = strtoupper($nomeCategoria);
        $nomeProduto    = strtoupper($nomeProduto);

        $categorias = $this->listarCategoriasObj();

        $achouCategoria = false;
        $achouProduto   = false;
        foreach($categorias as $c){
            if($c->nomeCategoria == $nomeCategoria){
                $achouCategoria = true;
                foreach($c->produtos as $p){
                    if($p->nomeProduto == $nomeProduto){
                        $achouProduto = true;
                        break;
                    }
                }
                break;
            }
        }

        if($achouCategoria){
            if($achouProduto){
                $mensagem = "A categoria $nomeCategoria é do produto $nomeProduto.";
            }else{
                $mensagem = "O produto $nomeProduto nao esta cadastrado ou nao pertence a categoria $nomeCategoria";
            }
        }else{
            $mensagem = "Categoria nao cadastrada";
        }

        return $this->render('CategoriaBundle:Default:exercicio2.html.twig',array('mensagem' => $mensagem));
    }

    private function listarCategorias()
    {
        $categorias = array (
            'COMIDA' =>  array('ARROZ', 'FEIJAO'),
            'HIGIENE' => array('SHAMPO', 'SABONETE'),
            'LIMPEZA' => array('DETERGENTE', 'ESPONJA')
        );

        return $categorias;
    }

    private function listarCategoriasObj()
    {
        $categorias = array();

        $cat1 = new stdClass();
        $cat1->idCategoria = 1;
        $cat1->nomeCategoria = "COMIDA";
        $cat1->produtos = $this->listarProdutosObj($cat1->idCategoria);
        $categorias[] = $cat1;

        $cat2 = new stdClass();
        $cat2->idCategoria = 2;
        $cat2->nomeCategoria = "HIGIENE";
        $cat2->produtos = $this->listarProdutosObj($cat2->idCategoria);
        $categorias[] = $cat2;

        $cat3 = new stdClass();
        $cat3->idCategoria = 3;
        $cat3->nomeCategoria = "LIMPEZA";
        $cat3->produtos = $this->listarProdutosObj($cat3->idCategoria);
        $categorias[] = $cat3;

        return $categorias;
    }

    private function listarProdutosObj($idCategoria)
    {
        $produtos = array();
        switch ($idCategoria){
            case 1:
                $prod1 = new stdClass();
                $prod1->idProduto = 1;
                $prod1->nomeProduto = "ARROZ";
                $prod1->idCategoria = 1;
                $produtos[] = $prod1;

                $prod2 = new stdClass();
                $prod2->idProduto = 2;
                $prod2->nomeProduto = "FEIJAO";
                $prod2->idCategoria = 1;
                $produtos[] = $prod2;
            break;

            case 2:
                $prod1 = new stdClass();
                $prod1->idProduto = 3;
                $prod1->nomeProduto = "SHAMPO";
                $prod1->idCategoria = 2;
                $produtos[] = $prod1;

                $prod2 = new stdClass();
                $prod2->idProduto = 4;
                $prod2->nomeProduto = "SABONETE";
                $prod2->idCategoria = 2;
                $produtos[] = $prod2;
            break;

            case 3:
                $prod1 = new stdClass();
                $prod1->idProduto = 5;
                $prod1->nomeProduto = "DETERGENTE";
                $prod1->idCategoria = 3;
                $produtos[] = $prod1;

                $prod2 = new stdClass();
                $prod2->idProduto = 6;
                $prod2->nomeProduto = "ESPONJA";
                $prod2->idCategoria = 3;
                $produtos[] = $prod2;
            break;
        }

        return $produtos;
    }

}