<?php

namespace App\Controller\Admin;

use App\Entity\Apprenant;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
class ApprenantCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Apprenant::class;
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
     public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPaginatorPageSize(10)   // nombre d’éléments par page
            ->setPaginatorRangeSize(4);  // nombre de pages visibles dans la pagination
    }
}
