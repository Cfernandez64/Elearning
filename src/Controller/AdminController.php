<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Cour;
use App\Entity\User;
use App\Repository\CourRepository;
use App\Repository\UserRepository;


class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(CourRepository $repo, UserRepository $repos)
    {

        $cours = $repo->findBy(array(), array('createdAt' => 'DESC'), 3);
        $stagiaires = $repos->findAll();

        return $this->render('admin/index.html.twig', [
            'cours' => $cours,
            'stagiaires' => $stagiaires
        ]);
    }
}
