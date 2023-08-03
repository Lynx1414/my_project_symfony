<?php

namespace App\Controller\Admin;

use App\Entity\Enseignes;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class EnseignesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Enseignes::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
