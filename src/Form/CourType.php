<?php

namespace App\Form;

use App\Entity\Cour;
use App\Entity\Contenu;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class CourType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('duration')
            ->add('teacher')
            ->add('description')
            ->add('contenus', EntityType ::class, [
                'class' => Contenu::class,
                'choice_label'  => 'title',
                'multiple'  => true,
                'by_reference' => false,
                'required'  => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cour::class,
        ]);
    }
}
