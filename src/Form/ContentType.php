<?php

namespace App\Form;

use App\Entity\Content;
use App\Entity\Lesson;
use App\Entity\LessonsContents;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use KMS\FroalaEditorBundle\Form\Type\FroalaEditorType; // Symfony 4

class ContentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('content')
            ->add('slug')
            ->add('inLessons', EntityType ::class, [
                'class' => Lesson::class,
                'choice_label'  => 'title',
                'multiple'  => true,
                'by_reference' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Content::class,
        ]);
    }
}
