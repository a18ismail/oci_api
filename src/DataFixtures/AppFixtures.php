<?php

namespace App\DataFixtures;

use App\Entity\Pelicula;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        for ($i=0; $i<10; $i++){
            $pelicula = new Pelicula();
            $pelicula->setNom('Pelicula '.$i)
                ->setGenere('Genere Aleatori')
                ->setDescripcio('Descripcio de la pelicula '. $i);

            $manager->persist($pelicula);
        }



        $manager->flush();
    }
}
