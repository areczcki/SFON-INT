<?php

namespace SON\UserBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use SON\UserBundle\Entity\User;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;

class LoadUser extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
{
	private $container;

	public function load(ObjectManager $manager)
	{
		$user = new User();
		$user->setUsername('user')
		->setPlainPassword('user')
		->setIsActive(true)
		->setEmail('user@son.com');

		$manager->persist($user);

		$this->addReference('user-user', $user);

		$admin = new User();
		$admin->setUsername('admin')
		->setPlainPassword('admin')
		->setIsActive(true)
		->setRoles(array('ROLE_ADMIN'))
		->setEmail('user@son.com');

		$manager->persist($admin);

		$manager->flush();
	}


	public function setContainer(ContainerInterface $container = null)
	{
		$this->container = $container;
	}

	/**
	 * {@inheritDoc}
	 * @see \Doctrine\Common\DataFixtures\OrderedFixtureInterface::getOrder()
	 */
	public function getOrder() {
		// Verifica esse retornos para ordenar a ordem de execução
		return 10;
	}

}