<?php

namespace SON\CategoriaBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use SON\CategoriaBundle\Entity\Produto;

/**
 * Categoria
 *
 * @ORM\Table(name="categoria")
 * @ORM\Entity(repositoryClass="SON\CategoriaBundle\Entity\CategoriaRepository")
 */
class Categoria
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=255)
     */
    private $nome;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Produto", mappedBy="categoria")
     */
    protected $produtos;

    public function __construct(){
        $this->produtos = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nome
     *
     * @param string $nome
     * @return Categoria
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome
     *
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @return Collection
     */
    public function getProdutos()
    {
        return $this->produtos;
    }

    /**
     * @param Collection $produtos
     */
    public function setProdutos($produtos)
    {
        $this->produtos = $produtos;
    }


    /**
     * Add produtos
     *
     * @param \SON\CategoriaBundle\Entity\Produto $produtos
     * @return Categoria
     */
    public function addProduto(\SON\CategoriaBundle\Entity\Produto $produtos)
    {
        $this->produtos[] = $produtos;
    
        return $this;
    }

    /**
     * Remove produtos
     *
     * @param \SON\CategoriaBundle\Entity\Produto $produtos
     */
    public function removeProduto(\SON\CategoriaBundle\Entity\Produto $produtos)
    {
        $this->produtos->removeElement($produtos);
    }
}