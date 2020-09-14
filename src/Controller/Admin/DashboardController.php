<?php

namespace App\Controller\Admin;

use App\Entity\Blog;
use App\Entity\Reservation;
use App\Entity\Room;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $reservation= $this->get(CrudUrlGenerator::class)->build()->setController(ReservationCrudController::class)->generateUrl();
        return $this->redirect($reservation);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('MHotel');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Chambres', 'fa fa-tags', Room::class);
        yield MenuItem::linkToCrud('Reservation', 'fa fa-tags', Reservation::class);
        yield MenuItem::linkToCrud('Blog', 'fa fa-blog', Blog::class);
    }
}
