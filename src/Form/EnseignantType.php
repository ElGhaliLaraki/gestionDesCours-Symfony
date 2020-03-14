<?php

namespace App\Form;

use App\Entity\Enseignant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EnseignantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nom')
            ->add('Prenom')
            ->add('Email')
            ->add('Departement')
            ->add('Tel')
            ->add('Matricule')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Enseignant::class,
        ]);
    }
}
