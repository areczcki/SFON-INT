<?php

namespace SON\CatalogoBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use SON\CatalogoBundle\Entity\Catalogo;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadCatalogo extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
    	
    	$user = $this->getReference('user-user');
    	
        $catalogo = new Catalogo;
        $catalogo->setName('Quadros futuristas')
            ->setDescricao('Acervo de quadros futuristas')
            ->setLancamento(new \DateTime("now"))
            ->setImageName('futuristas.png')
        	->setAutor($user);

        $catalogo2 = new Catalogo;
        $catalogo2->setName('Quadros antigos')
            ->setDescricao('Acervo de quadros antigos')
            ->setLancamento(new \DateTime("yesterday noon"))
            ->setImageName('antigos.png')
        	->setAutor($user);;

        $manager->persist($catalogo);
        $manager->persist($catalogo2);

        $manager->flush();
    }
    
	/**
	 * {@inheritDoc}
	 * @see \Doctrine\Common\DataFixtures\OrderedFixtureInterface::getOrder()
	 */
	public function getOrder() {
		// Verifica esse retornos para ordenar a ordem de execução
		return 20;
	}

}