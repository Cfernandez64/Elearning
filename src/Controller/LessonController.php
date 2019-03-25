<?php

namespace App\Controller;

use App\Repository\AdvanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Lesson;
use App\Entity\Content;
use App\Entity\User;
use App\Entity\LessonContent;
use App\Form\LessonType;
use App\Form\ContentType;
use App\Form\RankType;
use App\Repository\LessonRepository;
use App\Repository\LessonContentRepository;
use App\Repository\ContentRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class LessonController extends AbstractController
{




    /**
     * @Route("/lesson/new", name="lesson_create")
     * @Route("lesson/{id}/edit", name="lesson_edit")
     **/
    public function formLesson(Lesson $lesson = null, LessonContent $lessonContent = null, LessonContentRepository $repo, Request $request, ObjectManager $manager)
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


            $contents = $form->get('contents')->getData();

            $hasLesson = $repo->findBy(array('lesson' => $lesson->getId()));

            //ID des enregistrements déjà existants
            $ids = array();

            //ID des contents choisies dans le formulaire
            $contentsId = array();

            //ID des contents associées aux lessons déjà enregistrées dans la table
            $alreadyContent = array();

            //Crée le tableau d'id des contenus
            foreach ($hasLesson as $lessonId)
            {
                array_push($ids, $lessonId->getId());
                array_push($alreadyContent, $lessonId->getContent()->getId());
            }

            //Crée le tableau id des lessons
            foreach ($contents as $content)
            {
                array_push($contentsId, $content->getId());
            }

            //boucle sur le tableau d'id
            foreach($ids as $id)
            {
                $bd = $repo->findOneBy(array('id' => $id));
                if (!in_array($bd->getContent()->getId(), $contentsId))
                {
                    //On supprime si l'enregistrement n'est pas dans le tableau des contents choisies
                    $repo->deleteDataInLessonContent($id);
                }
            }

            //On boucle sur les lessons choisies
            foreach ($contents as $content)
            {
                //Si le content n'existe pas dans les enregistrements on l'ajoute à la table
                if(!in_array($content->getId(), $alreadyContent))
                {
                    $ranker = new LessonContent();
                    $ranker->setLesson($lesson);
                    $ranker->setContent($content);
                    $manager->persist($ranker);
                    $manager->flush();
                }
            }

            return $this->redirectToRoute('lesson_show', ['id' => $lesson->getId()]);
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
    public function formContent(Content $content = null, LessonContent $lessonContent = null, LessonContentRepository $repo, Request $request, ObjectManager $manager)
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

            $lessons = $form->get('lessons')->getData();

            $hasContent = $repo->findBy(array('content' => $content->getId()));

                //ID des enregistrements déjà existants
                $ids = array();

                //ID des lessons choisies dans le formulaire
                $lessonsId = array();

                //ID des lessons associées aux contenus déjà enregistrées dans la table
                $alreadyLesson = array();

                //Crée le tableau d'id des contenus
                foreach ($hasContent as $contentId)
                {
                    array_push($ids, $contentId->getId());
                    array_push($alreadyLesson, $contentId->getLesson()->getId());
                }

                //Crée le tableau id des lessons
                foreach ($lessons as $lesson)
                {
                    array_push($lessonsId, $lesson->getId());
                }

                //boucle sur le tableau d'id
                foreach($ids as $id)
                {
                    $bd = $repo->findOneBy(array('id' => $id));
                    if (!in_array($bd->getLesson()->getId(), $lessonsId))
                    {
                        //On supprime si l'enregistrement n'est pas dans le tableau des lessons choisies
                        $repo->deleteDataInLessonContent($id);
                    }
                }

                //On boucle sur les lessons choisies
                foreach ($lessons as $lesson)
                {
                    //Si la lesson n'existe pas dans les enregistrements on l'ajoute à la table
                    if(!in_array($lesson->getId(), $alreadyLesson))
                    {
                        $ranker = new LessonContent();
                        $ranker->setLesson($lesson);
                        $ranker->setContent($content);
                        $manager->persist($ranker);
                        $manager->flush();
                    }
                }

            return $this->redirectToRoute('lesson');
        }

        return $this->render('lesson/createContent.html.twig', [
            'formContent' => $form->createView(),
            'editMode'  => $content->getId() !== null
        ]);
    }


    /**
     * @Route("/lesson", name="lesson")
     */
    public function index(LessonRepository $repo)
    {
        $lessons = $repo->findAll();
        return $this->render('lesson/index.html.twig', [
            'lessons' => $lessons
        ]);
    }



    /**
     * @IsGranted({"ROLE_ADMIN", "ROLE_STAGIAIRE"})
     * @Route("/lesson/{id}", name="lesson_show")
     **/
    public function show(Lesson $lesson, LessonContent $lessonContent = null, AdvanceRepository $adv, LessonContentRepository $repo)
    {

        $ranks = $repo->findBy(array('lesson' => $lesson->getId()), array('rank' => 'ASC'));
        $user = $this->getUser();
        $progres = array();
        foreach ($ranks as $rank)
        {
            $prog = $adv->findOneBy(array('user' => $user->getId(), 'content' => $rank->getContent()->getId()));
            array_push($progres, $prog);
        }
        return $this->render('lesson/show.html.twig', [
            'lesson' => $lesson,
            'ranks' => $ranks,
            'progres' => $progres
        ]);
    }



    /**
     * @Route("/lesson/lesson-{lesson_id}-{content_id}/update-rank", name="update_rank")
     **/
    public function updaterank($content_id, $lesson_id, LessonContent $lessonContent = null, Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $content = $entityManager->getRepository(LessonContent::class)->findBy(array('content'=>$content_id , 'lesson'=>$lesson_id));

        if(!$content)
        {
            throw $this->createNotFoundException(
                'Désolé action impossible'
            );
        }
        $rank = $_POST['rank'];
        foreach($content as $unique)
        {
            $unique->setRank($rank);
            $entityManager->flush();
        }

        return $this->redirectToRoute('lesson_show', ['id' => $lesson_id]);

    }

    /**
     * @Route("/lesson/{lesson_id}/{content_id}-{slug}", name="content_learn")
     */
    public function learn($lesson_id, $content_id, ContentRepository $repo, LessonContentRepository $repos, LessonRepository $repoc)
    {
        $content = $repo->find($content_id);
        $lesson = $repoc->find($lesson_id);
        $ranks = $repos->findBy(array('lesson' => $lesson->getId()), array('rank' => 'ASC'));

        return $this->render('lesson/learn.html.twig', [
            'content'   => $content,
            'lesson'   => $lesson,
            'ranks' => $ranks
        ]);
    }

}
