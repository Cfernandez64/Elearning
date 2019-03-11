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
     * @Route("/cour", name="cour")
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
     * @Route("/cour/new", name="cour_create")
     * @Route("cour/{id}/edit", name="cour_edit")
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
            if (!$cour->getId())
            {
                $cour->setCreatedAt(new \DateTime());

            }
            $manager->persist($cour);
            $manager->flush();

            return $this->redirectToRoute('cour');
        }

        return $this->render('cour/createCour.html.twig', [
            'formCour' => $form->createView(),
            'editMode'  => $cour->getId() !== null
        ]);
    }

    /**
     * @Route("/cour/contenu/new", name="contenu_create")
     * @Route("cour/contenu/{id}/edit", name="contenu_edit")
     **/
    public function form(Contenu $contenu = null, ContenuRepository $repo, Request $request, ObjectManager $manager)
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

            return $this->redirectToRoute('cour');
        }

        return $this->render('cour/create.html.twig', [
            'formContenu' => $form->createView(),
            'editMode'  => $contenu->getId() !== null
        ]);
    }

    /**
     * @Route("/cour/contenu-{contenu_id}/update-rank", name="update_rank")
     **/
    public function updateRank($contenu_id, Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $contenu = $entityManager->getRepository(Contenu::class)->find($contenu_id);

        if(!$contenu)
        {
            throw $this->createNotFoundException(
                'Désolé action impossible'
            );
        }
        $rank = $_POST['rank'];

        $contenu->setRank($rank);
        $entityManager->flush();
        $cour_id = $_POST['cour_id'];
        return $this->redirectToRoute('cour_show', ['id' => $cour_id]);
    }


    /**
     * @Route("/cour/{id}", name="cour_show")
     **/
    public function show(Cour $cour)
    {
        return $this->render('cour/show.html.twig', [
            'cour' => $cour
        ]);
    }

    /**
     * @Route("/cour/{cour_id}/{contenu_id}-{slug}", name="contenu_learn")
     */
    public function learn($cour_id, $contenu_id, ContenuRepository $repo, CourRepository $repoc)
    {
        $contenu = $repo->find($contenu_id);
        $cour = $repoc->find($cour_id);
        return $this->render('cour/learn.html.twig', [
            'contenu'   => $contenu,
            'cour'   => $cour
        ]);
    }
}
