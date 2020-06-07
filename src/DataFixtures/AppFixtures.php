<?php

namespace App\DataFixtures;

use App\Entity\Pelicula;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $pelicula = new Pelicula();
        $pelicula->setNom('Pelicula')
            ->setGenere('terror')
            ->setDescripcio('Descripcio de la pelicula.');

        $manager->persist($pelicula);

        $manager->flush();
    }
}
