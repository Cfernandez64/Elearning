<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CoursesRepository;
use App\Entity\Courses;

class CoursesController extends AbstractController
{
    /**
     * @Route("/cours", name="courses")
     */
    public function index(CoursesRepository $repo)
    {
        $courses = $repo->findAll();
        return $this->render('courses/index.html.twig', [
            'controller_name' => 'CoursesController',
            'courses' => $courses
        ]);
    }

    /**
     * @Route("/cours/{id}", name="cours_show")
     **/
    public function show(Courses $courses)
    {
        return $this->render('courses/show.html.twig', [
            'cours' => $courses
        ]);
    }
}
