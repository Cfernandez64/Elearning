<?php

namespace App\Controller;

use App\Entity\Cour;
use App\Entity\Contenu;
use App\Entity\Advance;
use App\Repository\AdvanceRepository;
use App\Repository\CourRepository;
use App\Repository\ContenuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Form\UserType;
use App\Form\AdvanceType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/users/new", name="user_create")
     * @ROUTE("/users/{id}/edit", name="user_edit")
     */
    public function formUser(User $user = null, UserRepository $repo, Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {
        if(!$user)
        {
            $user = new User();
        }

        $form = $this->createForm(UserType ::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $manager->persist($user);
            $manager->flush();

            $cour = $form->get('inCour')->getData();
            $data = $cour->getId();
            return $this->redirectToRoute('advance_edit', ['user' => $user->getId(), 'cour' => $data ]);
        }

        return $this->render('user/edit.html.twig', [
            'formUser' => $form->createView(),
            'editMode'  => $user->getId() !== null,
            'user'        => $user
        ]);
    }


    /**
     * @ROUTE("/users/{user}/{cour}/advance", name="advance_edit")
     */
    public function advance(Advance $advance = null, AdvanceRepository $repo, User $user, Cour $cour, Request $request, ObjectManager $manager)
    {
        if (!$advance)
        {

            $contenus = $cour->getContenus();

            foreach($contenus as $contenu)
            {
                $advance = new Advance();
                $advance->setUser($user);
                $advance->setContenuId($contenu->getId());
                $manager->persist($advance);
                $manager->flush();
            }
            return $this->redirectToRoute('user_show', ['id' => $user->getId()]);
        }

        return $this->redirectToRoute('user_show', ['id' => $user->getId()]);


    }

    /**
     * @Route("/users", name="user")
     */
    public function index(UserRepository $repo)
    {
        $users = $repo->findAll();

        return $this->render('user/index.html.twig', [
            'controller_name' => 'SecurityController',
            'users'        => $users
        ]);
    }

    /**
     * @Route("/admin/users/{id}", name="user_show")
     */
    public function show(User $user, CourRepository $repo, ContenuRepository $repos, AdvanceRepository $repoad)
    {
        $isCour = $user->getInCour()->getId();
        $cour = $repo->findOneBy(array('id' => $isCour));
        $contenus = $repos->findBy(array('inCour' => $cour));

        $progres = $repoad->findBy(array('user' => $user->getId()));

        return $this->render('user/show.html.twig', [
            'user' => $user,
            'cour' => $cour,
            'contenus' => $contenus,
            'progres' => $progres
        ]);
    }

    /**
     * @Route("/users/{id}/{cour_id}/advances", name="user_advance")
     */
    public function createAdvances($user, $cour)
    {
        $contenus = $cour->getContenus();
    }
}
