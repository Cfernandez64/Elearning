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
     * @Route("/admin", name="admin")
     */
    public function index(LessonRepository $repo, UserRepository $repos)
    {

        $lessons = $repo->findBy(array(), array('createdAt' => 'DESC'), 3);
        $stagiaires = $repos->findAll();

        return $this->render('admin/dashboard.html.twig', [
            'lessons' => $lessons,
            'stagiaires' => $stagiaires
        ]);
    }


    /**
     * @Route("/admin/users/new", name="user_create")
     * @ROUTE("/admin/users/{id}/edit", name="user_edit")
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

            $lesson = $form->get('inLesson')->getData()->getId();
            return $this->redirectToRoute('user_advance', ['user' => $user->getId(), 'lesson' => $lesson]);
        }

        return $this->render('user/edit.html.twig', [
            'formUser' => $form->createView(),
            'editMode'  => $user->getId() !== null,
            'user'        => $user
        ]);
    }
    /**
     * @Route("/admin/users/{user}-{lesson}/advance", name="user_advance")
     */
    public function advance(Advance $advance = null, AdvanceRepository $repo, LessonContentRepository $repos, User $user, Lesson $lesson, Request $request, ObjectManager $manager)
    {
         //Contents déjà en base associé à la lesson
        $contents = $repos->findBy(array('lesson' => $lesson->getId()));
        $ids = $repo->findBy(array('user' => $user->getId()));
        $userContent = array();
        foreach ($ids as $id)
        {
            array_push($userContent, $id->getContent()->getId());
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

        return $this->redirectToRoute('user_show', ['id' => $user->getId()]);
    }

    /**
     * @Route("/admin/users", name="user")
     */
    public function indexUser(UserRepository $repo)
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
    public function show(User $user, LessonRepository $repo, LessonContent $lessonContent = null, LessonContentRepository $repos, AdvanceRepository $repoad)
    {
        if($user->getInLesson())
        {
            $isLesson = $user->getInLesson()->getId();
            $lesson = $repo->findOneBy(array('id' => $isLesson));
            $contents = $repos->findBy(array('lesson' => $lesson));

            foreach($contents as $content)
            {

                $progres = $repoad->findBy(array('user' => $user->getId()));
            }

            return $this->render('user/show.html.twig', [
                'user' => $user,
                'contents' => $contents,
                'progres' => $progres
            ]);
        } else {
            return $this->render('user/show.html.twig', [
                'user' => $user
            ]);
        }

    }


}
