<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            ImageField::new('coverImage')->setBasePath('/uploads/article_image/')->setLabel('Image')->onlyOnIndex(),
            IdField::new('id')->onlyOnIndex(),
            SlugField::new('slug')->setTargetFieldName('titre'),
            TextField::new('titre'),
            Field::new('imageFile')->setFormType(VichImageType::class)->onlyOnForms(),
            AssociationField::new('category'),
            IntegerField::new('readTime'),
            TextEditorField::new('content'),
            DateField::new('createdAt')->onlyOnIndex()
        ];
    }
}
