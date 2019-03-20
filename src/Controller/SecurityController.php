<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Form\RegistrationType;
use App\Form\UserType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class SecurityController extends AbstractController
{
    /**
    * @Route("/inscription", name="security_registration")
    **/

    public function registration(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {
      $user = new User();
      $form = $this->createForm(RegistrationType::class, $user);

      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid())
      {
          $hash = $encoder->encodePassword($user, $user->getPassword());
          $user->setPassword($hash);
          $manager->persist($user);
          $manager->flush();
          return $this->redirectToRoute('security_login');
      }

      return $this->render('security/registration.html.twig', [
        'form'  => $form->createView()
      ]);
    }

    /**
     * @Route("/login", name="security_login")
     **/

    public function login(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {
        return $this->render('security/login.html.twig', [

        ]);
    }

    /**
     * @Route("/deconnexion", name="security_logout")
     */
    public function logout(){}


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

            return $this->redirectToRoute('user_show', ['id' => $user->getId()]);
        }

        return $this->render('user/edit.html.twig', [
            'formUser' => $form->createView(),
            'editMode'  => $user->getId() !== null,
            'user'        => $user
        ]);
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
     * @Route("/users/{id}", name="user_show")
     */
    public function show(User $user)
    {
        return $this->render('user/show.html.twig', [
            'user'        => $user
        ]);
    }


}
