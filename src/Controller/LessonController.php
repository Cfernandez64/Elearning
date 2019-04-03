<?php

namespace App\Controller;

use App\Repository\AdvanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Lesson;
use App\Entity\Content;
use App\Entity\User;
use App\Entity\Advance;
use App\Entity\LessonContent;
use App\Form\LessonType;
use App\Form\ContentType;
use App\Form\RankType;
use App\Repository\LessonRepository;
use App\Repository\LessonContentRepository;
use App\Repository\ContentRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class LessonController extends AbstractController
{

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
        $progres = [];
        foreach ($ranks as $rank)
        {
            $prog = $adv->findOneBy(array('user' => $user->getId(), 'content' => $rank->getContent()->getId()));
            $progres[] = $prog;
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

    /**
     * @Route("/content/{content_id}/{user_id}", name="advance_update")
     */
     public function validContent($content_id, $user_id, ObjectManager $manager, AdvanceRepository $repo, ContentRepository $repos, UserRepository $us)
     {
       $advance = $repo->findOneBy(['user' => $user_id, 'content' => $content_id]);
       $content = $repos->find($content_id);
       $user = $us->find($user_id);
       $valid = 100;
       if($advance)
       {
         $advance->setPercentage($valid);
         $manager->persist($advance);
         $manager->flush();
       } else {
         $advance = new Advance();
         $advance->setPercentage($valid)
                 ->setUser($user)
                 ->setContent($content);
       }
       return $this->redirectToRoute('lesson');
     }
}
