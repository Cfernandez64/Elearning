<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Entity\Content;
use App\Entity\LessonContent;
use App\Entity\Advance;
use App\Repository\AdvanceRepository;
use App\Repository\LessonRepository;
use App\Repository\LessonContentRepository;
use App\Repository\ContentRepository;
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
     * @Route("/dashboard", name="user_dashboard")
     */
     public function userDashboard(UserRepository $repo, AdvanceRepository $repoc, LessonContentRepository $repos)
     {
       $this->denyAccessUnlessGranted(['ROLE_STAGIAIRE', 'ROLE_ADMIN']);
       $user = $this->getUser();

       return $this->render('user/user_dashboard.html.twig', [
           'user'        => $user
       ]);
     }

    /**
     * @Route("/admin/users/new", name="user_create")
     * @ROUTE("/admin/users/{id}/edit", name="user_edit")
     */
    public function formUser(User $user = null, UserRepository $repo, AdvanceRepository $repoc, LessonContentRepository $repos, Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
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

            $lessons = $form->get('inLessons')->getData();

            foreach ($lessons as $lesson)
            {
                //Contents déjà en base associé à la lesson
                $contents = $repos->findBy(array('lesson' => $lesson->getId()));

                $ids = $repoc->findBy(array('user' => $user->getId()));
                $userContent = [];
                foreach ($ids as $id)
                {
                    $userContent[] =  $id->getContent()->getId();
                }

                if (!$ids)
                {
                    foreach ($contents as $content)
                    {
                        $advance = new Advance();
                        $advance->setUser($user);
                        $advance->setContent($content->getContent());
                        $manager->persist($advance);
                        $manager->flush();
                    }
                } else {
                    foreach ($contents as $content)
                    {
                        if(!in_array($content->getContent()->getId(), $userContent))
                        {
                            $advance = new Advance();
                            $advance->setUser($user);
                            $advance->setContent($content->getContent());
                            $manager->persist($advance);
                            $manager->flush();
                        }
                    }
                }
            }

            return $this->redirectToRoute('user');
        }

        return $this->render('admin/user_edit.html.twig', [
            'formUser' => $form->createView(),
            'editMode'  => $user->getId() !== null,
            'user'        => $user
        ]);
    }


    /**
     * @Route("/admin/users", name="user")
     */
    public function indexUser(UserRepository $repo)
    {
        $users = $repo->findAll();

        return $this->render('admin/user_list.html.twig', [
            'controller_name' => 'SecurityController',
            'users'        => $users
        ]);
    }

    /**
     * @Route("/admin/users/{id}", name="user_show")
     */
    public function show(User $user, LessonRepository $repo, LessonContent $lessonContent = null, LessonContentRepository $repos, AdvanceRepository $repoad)
    {
        if($user->getInLessons())
        {
            $isLessons = $user->getInLessons();
            $progres = '';
            $contents = [];
            foreach ($isLessons as $isLesson) {
              $cont = $repos->findBy(array('lesson' => $isLesson->getId()));
              foreach ($cont as $con)
              {
                  $contents[] = $con;
              }
            }
             foreach($contents as $content)
             {
               $progres = $repoad->findBy(array('user' => $user->getId()));
             }

            return $this->render('admin/user_show.html.twig', [
                'user' => $user,
                'contents' => $contents,
                'progres' => $progres
            ]);
        } else {
            return $this->render('admin/user_show.html.twig', [
                'user' => $user
            ]);
        }
    }


}
