<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Form\ArticleContentType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

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
            TextField::new('titre', 'Titre'),
            Field::new('imageFile', 'Image de couverture')->setFormType(VichImageType::class)->onlyOnForms(),
            AssociationField::new('category', 'Catégorie'),
            IntegerField::new('readTime', 'Temps de lecture'),
            TextareaField::new('content')->setLabel('Contenu')->onlyOnForms()->setFormType(CKEditorType::class),
            DateField::new('createdAt', 'Date de création')->onlyOnIndex(),
            TextEditorField::new('content')->onlyOnIndex(),

        ];
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig');
    }
}
