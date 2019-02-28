<?php

namespace App\DataFixtures;

use App\Entity\Courses;
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
        }
        $manager->flush();
    }
}

