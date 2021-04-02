<?php

namespace App\Controller\Admin;

use App\Entity\Comments;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class CommentsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Comments::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            EmailField::new('email'),
            TextField::new('pseudo'),
            UrlField::new('website'),
            BooleanField::new('active'),
            TextEditorField::new('content'),
            AssociationField::new('article')
        ];
    }
}
