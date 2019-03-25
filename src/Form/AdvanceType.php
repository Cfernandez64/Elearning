<?php

namespace App\Form;

use App\Entity\Advance;
use App\Entity\User;
use App\Entity\Contenu;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdvanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user', EntityType ::class, [
                'class' => User::class,
                'choice_label'  => 'id'
            ])
            ->add('contenu', EntityType ::class, [
                'class' => Contenu::class,
                'choice_label'  => 'id'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Advance::class,
        ]);
    }
}
