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
use SON\CategoriaBundle\Entity\Produto;

class LoadProdutoData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $produto1 = new Produto();
        $produto1->setNome("Shampo");
        $produto1->setUnidade(1);

        $produto2 = new Produto();
        $produto2->setNome("Arroz");
        $produto2->setUnidade(2);

        $manager->persist($produto1);
        $manager->persist($produto2);

        $manager->flush();
    }
}