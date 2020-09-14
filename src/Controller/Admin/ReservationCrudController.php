<?php

namespace App\Controller\Admin;

use App\Entity\Reservation;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ReservationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reservation::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $startAt = DateField::new('startAt');
        $endAt= DateField::new('endAt');
        $comment = TextareaField::new('comment');
        $nbpersonne = NumberField::new('nbpersonne');
        $room= AssociationField::new('room');
        $user= AssociationField::new('user');





        if (Crud::PAGE_INDEX === $pageName) {
            return [$startAt, $endAt,$nbpersonne,$room,$user,$comment];
        }

        return [
            FormField::addPanel('Basic information'),
            $startAt, $endAt,$nbpersonne,$room,$user,$comment

        ];
    }
}
