<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Enseignes;
use App\Entity\Produits;
use App\Entity\Users;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_produit', TextType::class)
            ->add('description_produit', TextareaType::class)
            ->add('image_produit', FileType::class, array(
                'label' => 'Image du produit',
                'required' => false,
                'data_class' => null,
                'empty_data' => 'ce produit n\'a pas d\'image',
            ))
            ->add('stock_produit', CheckboxType::class)
            ->add('date_depot_produit', DateType::class, array(
                'widget' => 'single_text',
            ))
            ->add('prix_produit', NumberType::class)
            ->add('reference', ReferencesType::class, [
                'required' => true,
            ])
            ->add('enseignes', EntityType::class, [
                'class' => Enseignes::class,
                'choice_label'=> 'nomEnseigne',
                'label'=> 'Sélectionner une ou plusieurs enseigne(s)',
                'multiple' => true,
            ])
            ->add('category', EntityType::class, array(
                'class' => Categories::class,
                'choice_label'=> 'nomCategory',
                'required' => true,
            ))
            ->add('user', EntityType::class, array(
                'class' => Users::class,
                'disabled' => true,
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produits::class,
            'constraints' => array(new UniqueEntity(['fields' => 'nom_produit'], 'Ce nom de produit est indisponible !'))
        ]);
    }
}

//todo la propriete de class $reference sera a appellé dans  pour appeller la methode getNumeroReference() methode de la class References.php
//todo ReferencesType gère à la fois le type de l'input et imbrique le formulaire ReferencesType dans le formulaire ProduitsType
//todo ainsi quand on voudra ajouter un produit le form de ReferenceType sera inclus inside
