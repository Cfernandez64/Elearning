<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Entity\Content;
use App\Entity\Formateur;
use App\Entity\LessonContent;
use App\Entity\Advance;
use App\Repository\AdvanceRepository;
use App\Repository\LessonRepository;
use App\Repository\LessonContentRepository;
use App\Repository\ContentRepository;
use App\Repository\FormateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Form\UserType;
use App\Form\LessonType;
use App\Form\ContentType;
use App\Form\FormateurType;
use App\Form\AdvanceType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminController extends AbstractController
{

    /**
     * @Route("admin/lesson/new", name="lesson_create")
     **/
    public function createLesson(Lesson $lesson = null, LessonContent $lessonContent = null, LessonContentRepository $repo, Request $request, ObjectManager $manager)
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

            //Insertion en base intermédiaire
            //Liste des ID des contents choisies dans le formulaire
            $contents = $form->get('contents')->getData();

            //On boucle sur les contents choisis
            foreach ($contents as $content)
            {
                $ranker = new LessonContent();
                $ranker->setLesson($lesson);
                $ranker->setContent($content);
                $manager->persist($ranker);
                $manager->flush();
            }
            return $this->redirectToRoute('lesson_admin');
        }
        return $this->render('admin/lesson_create.html.twig', [
            'formLesson' => $form->createView()
        ]);
    }

    /**
     * @Route("admin/formateurs/new", name="formateur_create")
     **/
    public function createFormateur(Formateur $formateur = null, Request $request, ObjectManager $manager)
    {
        if(!$formateur)
        {
            $formateur = new Formateur();
        }

        $form = $this->createForm(FormateurType ::class, $formateur);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($formateur);
            $manager->flush();

            return $this->redirectToRoute('formateur_admin');
          }

        return $this->render('admin/formateur_create.html.twig', [
            'formFormateur' => $form->createView()
        ]);
    }

    /**
     * @Route("admin/lesson/{id}/edit", name="lesson_edit")
     */
    public function editLesson(Lesson $lesson = null, LessonContent $lessonContent = null, LessonContentRepository $repo, Request $request, ObjectManager $manager)
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
            $ids = [];

            //ID des contents choisies dans le formulaire
            $contentsId = [];

            //ID des contents associées aux lessons déjà enregistrées dans la table
            $alreadyContent = [];

            //Crée le tableau d'id des contenus
            foreach ($hasLesson as $lessonId)
            {
                $ids[] = $lessonId->getId();
                $alreadyContent[] = $lessonId->getContent()->getId();
            }

            //Crée le tableau id des lessons
            foreach ($contents as $content)
            {
                $contentsId[] = $content->getId();
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

            return $this->redirectToRoute('lesson_admin');
        }

        return $this->render('admin/lesson_create.html.twig', [
            'formLesson' => $form->createView(),
            'editMode'  =>  $lesson->getId() !== null
        ]);
    }

    /**
     * @Route("admin/content/new", name="content_create")
    **/
    public function createContent(Content $content = null, LessonContent $lessonContent = null, LessonContentRepository $repo, Request $request, ObjectManager $manager)
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

                //On boucle sur les lessons choisies
                foreach ($lessons as $lesson)
                {
                        $ranker = new LessonContent();
                        $ranker->setLesson($lesson);
                        $ranker->setContent($content);
                        $manager->persist($ranker);
                        $manager->flush();
                }

            return $this->redirectToRoute('content_admin');
        }

        return $this->render('admin/content_create.html.twig', [
        'formContent' => $form->createView()
        ]);
    }

    /**
     * @Route("admin/formateur/{id}/edit", name="formateur_edit")
    **/
    public function editFormateur(Formateur $formateur = null, Request $request, ObjectManager $manager)
    {
        $form = $this->createForm(FormateurType ::class, $formateur);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {

            $manager->persist($formateur);
            $manager->flush();

            return $this->redirectToRoute('formateur_admin');
        }

        return $this->render('admin/formateur_create.html.twig', [
        'formFormateur' => $form->createView(),
        'editMode'  => $formateur->getId() !== null
        ]);
    }

    /**
     * @Route("admin/content/{id}/edit", name="content_edit")
    **/
    public function editContent(Content $content = null, LessonContent $lessonContent = null, LessonContentRepository $repo, Request $request, ObjectManager $manager)
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
            $ids = [];

            //ID des lessons choisies dans le formulaire
            $lessonsId = [];

            //ID des lessons associées aux contenus déjà enregistrées dans la table
            $alreadyLesson = [];

            //Crée le tableau d'id des contenus
            foreach ($hasContent as $contentId)
            {
                $ids[] = $contentId->getId();
                $alreadyLesson[] = $contentId->getLesson()->getId();
            }

            //Crée le tableau id des lessons
            foreach ($lessons as $lesson)
            {
                $lessonsId[] = $lesson->getId();
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

            return $this->redirectToRoute('content_admin');
            }

        return $this->render('admin/content_create.html.twig', [
        'formContent' => $form->createView(),
        'editMode'  => $content->getId() !== null
        ]);
    }

    /**
     * @Route("admin/formateurs", name="formateur_admin")
    **/
    public function formateur(FormateurRepository $repo)
    {
      $formateur = $repo->findAll();

      return $this->render('admin/formateur_list.html.twig', [
      'formateurs' => $formateur
      ]);
    }

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
     * @Route("admin/lesson", name="lesson_admin")
     */
    public function lessons(LessonRepository $repo)
    {
        $lessons = $repo->findAll();
        return $this->render('admin/lesson_list.html.twig', [
            'lessons' => $lessons
        ]);
    }

    /**
     * @Route("admin/content", name="content_admin")
     */
    public function contents(ContentRepository $repo)
    {

        $contents = $repo->findAll();
        return $this->render('admin/content_list.html.twig', [
            'contents' => $contents
        ]);
    }


    /**
     * @Route("admin/formateur/{id}/delete", name="formateur_delete")
     */
    public function deleteFormateur(FormateurRepository $repo, $id, ObjectManager $manager)
    {
        $formateur= $repo->find($id);

        //Supprimer dans la table content
        $manager->remove($formateur);
        $manager->flush();

        return $this->redirectToRoute('formateur_admin');
    }

    /**
     * @Route("admin/content/{id}/delete", name="content_delete")
     */
    public function deleteContent(ContentRepository $repo, $id, LessonContentRepository $rep, AdvanceRepository $repos, ObjectManager $manager)
    {
        $content = $repo->find($id);
        $lessonContent = $rep->findBy(['content' => $id]);

        foreach ($lessonContent as $inter)
        {
            $rep->deleteDataInLessonContent($inter->getId());
        }

        $adv = $repos->findBy(['content' => $id]);
        foreach ($adv as $ad)
        {
            $repos->removeAdvance($ad);
        }

        //Supprimer dans la table content
        $manager->remove($content);
        $manager->flush();

        return $this->redirectToRoute('content_admin');
    }

    /**
     * @Route("admin/lesson/{id}/delete", name="lesson_delete")
     */
    public function deleteLesson(LessonRepository $repo, $id, LessonContentRepository $rep, UserRepository $repos, ObjectManager $manager)
    {
        $lesson = $repo->find($id);
        $lessonContent = $rep->findBy(['lesson' => $id]);

        foreach ($lessonContent as $inter)
        {
            $rep->deleteDataInLessonContent($inter->getId());
        }

        $users = $lesson->getUsers();
        foreach($users as $user)
        {
            $lesson->removeUser($user);
            $manager->persist($lesson);
            $manager->flush();
        }

        //Supprimer dans la table content
        $manager->remove($lesson);
        $manager->flush();

        return $this->redirectToRoute('lesson_admin');
    }



}
