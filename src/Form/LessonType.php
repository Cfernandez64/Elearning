<?php

namespace App\Form;

use App\Entity\Lesson;
use App\Entity\Content;
use App\Entity\LessonContent;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use KMS\FroalaEditorBundle\Form\Type\FroalaEditorType;

class LessonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('duration')
            ->add('contents', EntityType ::class, [
                'class' => Content::class,
                'choice_label'  => 'title',
                'multiple'  => true,
                'by_reference' => false
            ])
            ->add('teacher')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Lesson::class,
        ]);
    }
}
