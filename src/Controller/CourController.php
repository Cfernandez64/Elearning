<?php

namespace App\Controller;

use App\Repository\ContenuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CourRepository;
use App\Entity\Cour;
use App\Entity\Contenu;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\ContenuType;
use App\Form\CourType;

class CourController extends AbstractController
{
    /**
     * @Route("/cours", name="cours")
     */
    public function index(CourRepository $repo)
    {
        $cour = $repo->findAll();
        return $this->render('cour/index.html.twig', [
            'controller_name' => 'CourController',
            'cour' => $cour
        ]);
    }

    /**
     * @Route("/cours/new", name="cour_create")
     * @Route("cours/{id}/edit", name="cour_edit")
     **/
    public function formCour(Cour $cour = null, Request $request, ObjectManager $manager)
    {
        if(!$cour)
        {
            $cour = new Cour();
        }

        $form = $this->createForm(CourType ::class, $cour);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($cour);
            $manager->flush();

            return $this->redirectToRoute('cours');
        }

        return $this->render('cour/createCour.html.twig', [
            'formCour' => $form->createView(),
            'editMode'  => $cour->getId() !== null
        ]);
    }

    /**
     * @Route("/cours/contenu/new", name="contenu_create")
     * @Route("cours/contenu/{id}/edit", name="contenu_edit")
     **/
    public function form(Contenu $contenu = null, Request $request, ObjectManager $manager)
    {
        if(!$contenu)
        {
            $contenu = new Contenu();
        }

        $form = $this->createForm(ContenuType ::class, $contenu);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            if (!$contenu->getId())
            {
                $contenu->setCreatedAt(new \DateTime());
            }
            $manager->persist($contenu);
            $manager->flush();

            return $this->redirectToRoute('cours');
        }

        return $this->render('cour/create.html.twig', [
            'formContenu' => $form->createView(),
            'editMode'  => $contenu->getId() !== null
        ]);
    }

    /**
     * @Route("/cours/{id}", name="cour_show")
     **/
    public function show(Cour $cour, ContenuRepository $repo)
    {

        return $this->render('cour/show.html.twig', [
            'cour' => $cour
        ]);
    }

    /**
     * @Route("/cours/{cour_id}/{contenu_id}-{slug}", name="contenus_learn")
     */
    public function learn($contenu_id, $cour_id, ContenuRepository $repo, CourRepository $repoc)
    {
        $contenu = $repo->find($contenu_id);
        $cour = $repoc->find($cour_id);
        return $this->render('cour/learn.html.twig', [
            'content'   => $contenu,
            'cour'   => $cour
        ]);
    }


}
