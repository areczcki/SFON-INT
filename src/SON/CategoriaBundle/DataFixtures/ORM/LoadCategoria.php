<?php
/**
 * Created by PhpStorm.
 * User: alexandre
 * Date: 23/04/2016
 * Time: 00:15
 */

namespace SON\CategoriaBundle\Bundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SON\CategoriaBundle\Entity\Categoria;

class LoadCategoriaData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $categoria1 = new Categoria();
        $categoria1->setNome("Higiene");

        $categoria2 = new Categoria();
        $categoria2->setNome("Comidas");

        $manager->persist($categoria1);
        $manager->persist($categoria2);

        $manager->flush();
    }
}