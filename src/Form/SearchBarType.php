<?php

namespace App\Form;

use App\Entity\References;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\ChoiceList\Factory\Cache\ChoiceValue;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchBarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_produit', SearchType::class, array(
                'required' => false,
                'label' => 'Par son nom : ',
                'attr' => array(
                    'placeholder' => '',
                    'class' => 'form-control w-50 ms-3',
                )
                ));

        // ->add('nom_ref_produit', ProduitsType::class);

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
