<?php

namespace SON\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Serializable;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="SON\UserBundle\Entity\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class User implements AdvancedUserInterface
{
	
	public function __construct()
	{
		$this->salt = base_convert(sha1(uniqid(mt_rand(), true)),16,36);
		$this->catalogos = new ArrayCollection();
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
	 * @ORM\Column(name="username", type="string", length=255)
	 */
	private $username;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="password", type="string", length=255)
	 */
	private $password;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="salt", type="string", length=255)
	 */
	private $salt;
	
	/**
	 * @var array
	 *
	 * @ORM\Column(name="roles", type="array")
	 */
	private $roles = array();
	
	/**
	 * @var bool
	 *
	 * @ORM\Column(name="isActive", type="boolean")
	 */
	private $isActive = true;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="email", type="string", length=255)
	 */
	private $email;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="plainPassword", type="string", length=255, nullable=True)
	 */
	private $plainPassword;
	
	/**
	 * @var datetime $created
	 *
	 * @ORM\Column(type="datetime")
	 */
	private $created;
	
	/**
	 * @ORM\OneToMany(targetEntity="SON\CatalogoBundle\Entity\Catalogo", mappedBy="autor")
	 */
	protected $catalogos;
	
	
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
	 * Set username
	 *
	 * @param string $username
	 *
	 * @return User
	 */
	public function setUsername($username)
	{
		$this->username = $username;
	
		return $this;
	}
	
	/**
	 * Get username
	 *
	 * @return string
	 */
	public function getUsername()
	{
		return $this->username;
	}
	
	/**
	 * Set password
	 *
	 * @param string $password
	 *
	 * @return User
	 */
	public function setPassword($password)
	{
		$this->password = $password;
	
		return $this;
	}
	
	/**
	 * Get password
	 *
	 * @return string
	 */
	public function getPassword()
	{
		return $this->password;
	}
	
	/**
	 * Set salt
	 *
	 * @param string $salt
	 *
	 * @return User
	 */
	public function setSalt($salt)
	{
		$this->salt = $salt;
	
		return $this;
	}
	
	/**
	 * Get salt
	 *
	 * @return string
	 */
	public function getSalt()
	{
		return $this->salt;
	}
	
	/**
	 * Set roles
	 *
	 * @param array $roles
	 *
	 * @return User
	 */
	public function setRoles(array $roles)
	{
		$this->roles = $roles;
		return $this;
	}
	
	/**
	 * Get roles
	 *
	 * @return array
	 */
	public function getRoles()
	{
		$roles = $this->roles;
		$roles[] = "ROLE_USER";
		return array_unique($roles);
	}
	
	/**
	 * Set isActive
	 *
	 * @param boolean $isActive
	 *
	 * @return User
	 */
	public function setIsActive($isActive)
	{
		$this->isActive = $isActive;
	
		return $this;
	}
	
	/**
	 * Get isActive
	 *
	 * @return bool
	 */
	public function getIsActive()
	{
		return $this->isActive;
	}
	
	/**
	 * Set email
	 *
	 * @param string $email
	 *
	 * @return User
	 */
	public function setEmail($email)
	{
		$this->email = $email;
	
		return $this;
	}
	
	/**
	 * Get email
	 *
	 * @return string
	 */
	public function getEmail()
	{
		return $this->email;
	}
	
	/**
	 * Set plainPassword
	 *
	 * @param string $plainPassword
	 *
	 * @return User
	 */
	public function setPlainPassword($plainPassword)
	{
		$this->plainPassword = $plainPassword;
	
		return $this;
	}
	
	/**
	 * Get plainPassword
	 *
	 * @return string
	 */
	public function getPlainPassword()
	{
		return $this->plainPassword;
	}
	
	public function isAccountNonExpired()
	{
		return true;
	}
	
	public function isAccountNonLocked()
	{
		return true;
	}
	
	public function isCredentialsNonExpired()
	{
		return true;
	}
	
	public function isEnabled()
	{
		return $this->getIsActive();
	}
	
	public function eraseCredentials()
	{
		$this->setPlainPassword(null);
	}
	
	/**
	 * implementar o equals que não é obrigatório
	 * Servirá para garantir que está vindo por parametro
	 * é o mesmo da entidade
	 */
	
	public function equals(UserInterface $user){
		return $this->getId() == $user->getId();
	}
	
	/**
	 * Serializar a Entidade, caso preciso
	 * passar por algum parametro, ou jogar esse
	 * Objeto na Sessão é necessário serializar o
	 * Objeto
	 */
	public function serialize(){
		return serialize(
				array('id' => $this->getId())
				);
	}
	
	
	public function unserialize($serialized){
		$data =  unserialize($serialized);
		$this->id = $data['id'];
	}
	
	public function getCatalogos() {
		return $this->catalogos;
	}
	
	public function setCatalogos($catalogos) {
		$this->catalogos = $catalogos;
		return $this;
	}
	
	/**
	 * @param \SON\CatalogoBundle\Entity\datetime $created
	 */
	public function setCreated($created)
	{
		$this->created = $created;
	}
	
	/**
	 * @return \SON\CatalogoBundle\Entity\datetime
	 */
	public function getCreated()
	{
		return $this->created;
	}
	
	/**
	 * @ORM\PrePersist
	 */
	public function prePersist()
	{
		if(!$this->getCreated())
			$this->setCreated(new \DateTime());
	}
	
}