<?php

namespace App\Controller\Admin;

use App\Entity\Room;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class RoomCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Room::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $name = TextField::new('name');
        $description = TextareaField::new('description');
        $isAvalaible=BooleanField::new('isAvailable');
        $image = ImageField::new('imagefile')->setBasePath('images/rooms');
        $imagedisplay = ImageField::new('image')->setBasePath('images/rooms');
        $price = NumberField::new('price');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$name, $description, $price, $imagedisplay, $isAvalaible];
        }

        return [
            FormField::addPanel('Basic information'),
            $name, $description, $price, $image, $isAvalaible

        ];
    }

}
