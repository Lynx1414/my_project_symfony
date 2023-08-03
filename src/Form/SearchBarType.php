<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchBarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_produit', SearchType::class, array(
                'required' => false,
                'label' => 'Rechercher un produit :',
                'attr'=>array(
                    'placeholder' => 'Nom du produit',
                    'class' => 'form-control search-bar',
                    )
                ));

            // ->add('reference', ChoiceType::class, array(
            //     'choices' => array(
            //         'references' => 'references',
                    
            //         )
            //     ))

            // ->add('stock_produit', ChoiceType::class, [
            //     'choices' => [
            //         'In Stock' => true,
            //         'Out of Stock' => false,
            //     ],
            // ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
