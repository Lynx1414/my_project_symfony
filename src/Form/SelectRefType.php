<?php

namespace App\Form;

use App\Entity\References;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SelectRefType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('reference', EntityType::class, array(
            'class' => References::class,
            'label' => ' Par reference : ',
            'choice_label' => 'numero_reference',
            'attr' => array(
                'class' => 'mt-3 ms-2 p-1 ',
                
            ),
            'placeholder' => '-- Sélectionner --',
            'required' => false,
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
