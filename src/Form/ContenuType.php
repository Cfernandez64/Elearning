<?php

namespace App\Form;

use App\Entity\Contenu;
use App\Entity\Cour;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use KMS\FroalaEditorBundle\Form\Type\FroalaEditorType; // Symfony 4

class ContenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('content', FroalaEditorType::class)
            ->add('slug')
            ->add('relCours', EntityType ::class, [
                'class' => Cour::class,
                'choice_label'  => 'titre',
                'multiple'  => true,
                'by_reference' => false
            ])
          ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contenu::class,
        ]);
    }
}
