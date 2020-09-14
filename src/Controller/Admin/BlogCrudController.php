<?php

namespace App\Controller\Admin;

use App\Entity\Blog;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class BlogCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Blog::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $title = TextField::new('title');
        $slug = TextField::new('slug');
        $contenu = TextEditorField::new('contenu');
        $image = ImageField::new('imagefile')->setBasePath('images/blog');
        $imagedisplay = ImageField::new('image')->setBasePath('images/blog');


        if (Crud::PAGE_INDEX === $pageName) {
            return [$title, $slug, $contenu, $imagedisplay];
        }

        return [
            FormField::addPanel('Basic information'),
            $title, $contenu, $slug, $image

        ];
    }
}
