<?php

namespace App\Controller;


use App\Entity\LessonsContents;
use App\Repository\ContentRepository;
use App\Repository\LessonsContentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\LessonRepository;
use App\Entity\Lesson;
use App\Entity\Content;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\ContentType;
use App\Form\LessonType;
use App\Form\LessonsContentsType;

class LessonController extends AbstractController
{
    /**
     * @Route("/lesson", name="lesson")
     */
    public function index(LessonRepository $repo)
    {
        $lesson = $repo->findAll();
        return $this->render('lesson/index.html.twig', [
            'controller_name' => 'LessonController',
            'lesson' => $lesson
        ]);
    }

    /**
     * @Route("/lesson/new", name="lesson_create")
     * @Route("lesson/{id}/edit", name="lesson_edit")
     **/
    public function formLesson(Lesson $lesson = null, Request $request, ObjectManager $manager)
    {
        if(!$lesson)
        {
            $lesson = new Lesson();
        }

        $form = $this->createForm(LessonType ::class, $lesson);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            if (!$lesson->getId())
            {
                $lesson->setCreatedAt(new \DateTime());

            }
            $manager->persist($lesson);
            $manager->flush();

            return $this->redirectToRoute('lesson');
        }

        return $this->render('lesson/createLesson.html.twig', [
            'formLesson' => $form->createView(),
            'editMode'  => $lesson->getId() !== null
        ]);
    }

    /**
     * @Route("/lesson/content/new", name="content_create")
     * @Route("lesson/content/{id}/edit", name="content_edit")
     **/
    public function form(Content $content = null, ContentRepository $repo, Request $request, ObjectManager $manager)
    {
        if(!$content)
        {
            $content = new Content();
        }

        $form = $this->createForm(ContentType ::class, $content);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            if (!$content->getId())
            {
                $content->setCreatedAt(new \DateTime());

            }
            $manager->persist($content);
            $manager->flush();

            return $this->redirectToRoute('lesson');
        }

        return $this->render('lesson/create.html.twig', [
            'formContent' => $form->createView(),
            'editMode'  => $content->getId() !== null
        ]);
    }



    /**
     * @Route("/lesson/content-rank/new", name="rank_create")
     * @Route("/lesson/rank/edit", name="rank_edit")
     **/
    public function formRank(LessonsContents $rank = null, LessonsContentsRepository $repo, Request $request, ObjectManager $manager)
    {
        if(!$rank)
        {
            $rank = new LessonsContents();
        }

        $form = $this->createForm(LessonsContentsType ::class, $rank);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($rank);
            $manager->flush();

            return $this->redirectToRoute('lesson');
        }

        return $this->render('lesson/rank.html.twig', [
            'formRank' => $form->createView(),
            'editMode'  => $rank->getId() !== null
        ]);
    }



    /**
     * @Route("/lesson/{id}", name="lesson_show")
     **/
    public function show(Lesson $lesson)
    {
        return $this->render('lesson/show.html.twig', [
            'lesson' => $lesson
        ]);
    }

    /**
     * @Route("/lesson/{lesson_id}/{content_id}-{slug}", name="content_learn")
     */
    public function learn($content_id, $lesson_id, ContentRepository $repo, LessonRepository $repoc)
    {
        $content = $repo->find($content_id);
        $lesson = $repoc->find($lesson_id);
        return $this->render('lesson/learn.html.twig', [
            'content'   => $content,
            'lesson'   => $lesson
        ]);
    }
}
