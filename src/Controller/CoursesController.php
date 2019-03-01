<?php

namespace App\Controller;

use App\Repository\ContenuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CoursesRepository;
use App\Entity\Courses;
use App\Entity\Contenu;

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
     * @Route("/cours/{id}", name="courses_show")
     **/
    public function show(Courses $courses, ContenuRepository $repo)
    {

        return $this->render('courses/show.html.twig', [
            'cours' => $courses
        ]);
    }

    /**
     * @Route("/cours/{courses_id}/{contenu_id}-{slug}", name="contenus_learn")
     */
    public function learn($contenu_id, $courses_id, ContenuRepository $repo,  CoursesRepository $repoc)
    {
        $contenu = $repo->find($contenu_id);
        $cours = $repoc->find($courses_id);
        return $this->render('courses/learn.html.twig', [
            'content'   => $contenu,
            'cours'   => $cours
        ]);
    }

}
