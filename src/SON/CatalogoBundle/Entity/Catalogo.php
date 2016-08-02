<?php

namespace SON\CatalogoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use SON\UserBundle\Entity\User;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Catalogo
 *
 * @ORM\Table(name="catalogo")
 * @ORM\Entity(repositoryClass="SON\CatalogoBundle\Entity\CatalogoRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Catalogo
{
	
	public function __construct(){
		$this->like = new ArrayCollection();
	}
	
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="string", length=255)
     */
    private $descricao;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lancamento", type="datetime")
     */
    private $lancamento;

    /**
     * @var string
     *
     * @ORM\Column(name="imageName", type="string", length=255)
     */
    private $imageName;

	/**
	 * @var User
	 * 
	 * @ORM\ManyToOne(targetEntity="SON\UserBundle\Entity\User", cascade={"remove"}, inversedBy="catalogos")
	 * @ORM\JoinColumn(onDelete="CASCADE")
	 */
    private $autor;
    
    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;
    
    /**
     * @var datetime $created
     *
     * @ORM\Column(type="datetime")
     */
    private $created;
    
    /**
     * @var datetime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updated;
	
    /**
     * @ORM\ManyToMany(targetEntity="SON\UserBundle\Entity\User")
     * @ORM\JoinTable(
     *      joinColumns={@ORM\JoinColumn(onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(onDelete="CASCADE")}
     *      )
     */
    private $like;
    
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Catalogo
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     *
     * @return Catalogo
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;

        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set lancamento
     *
     * @param \DateTime $lancamento
     *
     * @return Catalogo
     */
    public function setLancamento($lancamento)
    {
        $this->lancamento = $lancamento;

        return $this;
    }

    /**
     * Get lancamento
     *
     * @return \DateTime
     */
    public function getLancamento()
    {
        return $this->lancamento;
    }

    /**
     * Set imageName
     *
     * @param string $imageName
     *
     * @return Catalogo
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * Get imageName
     *
     * @return string
     */
    public function getImageName()
    {
        return $this->imageName;
    }
	
	public function getAutor() {
		return $this->autor;
	}
	
	public function setAutor(User $autor) {
		$this->autor = $autor;
		return $this;
	}
	
	public function getSlug() {
		return $this->slug;
	}
	
	public function setSlug($slug) {
		$this->slug = $slug;
	}
	
	public function getCreated() {
		return $this->created;
	}
	
	public function setCreated($created) {
		$this->created = $created;
	}
	
	public function getUpdated() {
		return $this->updated;
	}
	
	public function setUpdated($updated) {
		$this->updated = $updated;
	}
	
	/**
	 * @ORM\PrePersist
	 */
	public function prePersist()
	{
		if(!$this->getCreated()){
			$this->setCreated(new \DateTime());
		}
	}
	
	public function getLike() {
		return $this->like;
	}
	
	public function hasLike(User $user)
	{
		return $this->getLike()->contains($user);
	}
	
	
}