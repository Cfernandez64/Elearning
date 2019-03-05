<?php

namespace App\DataFixtures;

use App\Entity\Cour;
use App\Entity\Contenu;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CourFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        //Créer trois cours fakés
        for ($i = 0; $i <= 3; $i++)
        {
          $cour = new Cour();
          $cour->setTitre($faker->sentence())
                 ->setDuration($faker->sentence(3))
                 ->setTeachers($faker->name())
                 ->setDescription($faker->paragraph(4));

          $manager->persist($cour);

              for ($k = 0; $k <= mt_rand(1,3); $k++)
              {
                  $contenu = new Contenu();
                  $contenu->setTitle($faker->sentence())
                          ->setContent($faker->realText(1500))
                          ->setSlug($faker->slug())
                          ->addRelCour($cour)
                          ->setCreatedAt($faker->dateTimeBetween('-6 months'));
                  $manager->persist($contenu);
              }

        }
        $manager->flush();
    }
}

