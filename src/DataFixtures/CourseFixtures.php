<?php

namespace App\DataFixtures;

use App\Entity\Courses;
use App\Entity\Section;
use App\Entity\Contenu;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CourseFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        //Créer trois cours fakés
        for ($i = 0; $i <= 3; $i++)
        {
          $course = new Courses();
          $course->setTitre($faker->sentence())
                 ->setDuration($faker->sentence(3))
                 ->setTeachers($faker->name())
                 ->setDescription($faker->paragraph(4));
          $manager->persist($course);

          for ($j = 0; $j <= mt_rand(2,5); $j++)
          {
              $section = new Section();
              $section->setTitle($faker->sentence())
                  ->setCours($course);
              $manager->persist($section);

              for ($k = 0; $k <= mt_rand(2,4); $k++)
              {
                  $contenu = new Contenu();
                  $contenu->setTitle($faker->sentence())
                          ->setContent($faker->realText(1500))
                          ->setSection($section)
                          ->addCour($course);
                  $manager->persist($contenu);
              }
          }
        }
        $manager->flush();
    }
}

