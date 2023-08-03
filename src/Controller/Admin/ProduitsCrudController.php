<?php

namespace App\Controller\Admin;

use App\Entity\Produits;
use App\Entity\Users;
use App\Form\ReferencesType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;


class ProduitsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Produits::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('id', 'ID')->onlyOnIndex(),
            TextField::new('nomProduit', 'Nom du produits'),
            TextEditorField::new('descriptionProduit', 'Description du produit'),
            NumberField::new('prixProduit', 'Prix du produit'),
            ImageField::new('imageProduit')
                ->setBasePath('/img')
                ->setUploadDir("public/img/")
                ->setFormType(FileUploadType::class)
                ->setRequired(false),
            BooleanField::new('stockProduit', 'Produits en stock ?'),
            DateTimeField::new('dateDepotProduit', 'Date de depot'),
            AssociationField::new('category', 'Catégories du produit'),
            AssociationField::new('enseignes', 'Liste des enseignes'),
            IntegerField::new('reference', 'Référence du produits')
            ->setFormType(ReferencesType::class),
            AssociationField::new('user', 'Utilisateur')
                 ->setFormTypeOptions(['class' => Users::class, 'choice_label' => 'email'])
        ];
    }
    
}

// ->onlyOnIndex()
// ->hideOnForm()