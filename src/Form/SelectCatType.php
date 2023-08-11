<?php

namespace App\Form;

use App\Entity\Categories;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SelectCatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('category', EntityType::class, array(
            'class' => Categories::class,
            'attr' => array(
                'class' => 'mt-3 ms-2 p-1'
            ),
            'label' => 'Par catégorie : ',
            'choice_label'=> 'nomCategory',
            'required' => false,
            'placeholder' => '-- Sélectionner --',
        ))

        ->add('submit', SubmitType::class, array(
            'label' => 'valider',
            'attr' => array(
                'class' => 'btn btn-outline-secondary btn-sm',
            ),
        ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
