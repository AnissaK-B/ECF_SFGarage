<?php

namespace App\Controller\Admin;

use App\Entity\Car;
use App\Entity\Formulaire;
use App\Entity\Schedule;
use App\Entity\Service;
use App\Entity\ServiceEmployee;
use App\Entity\Testimonials;
use Doctrine\ORM\Mapping\Entity;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Projet Garage');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Messages', 'fa-brands fa-wpforms', Formulaire::class);   
        yield MenuItem::linkToCrud('Commentaires', 'fa fa-message', Testimonials::class);   
        yield MenuItem::linkToCrud('Voitures', 'fa fa-car', Car::class);  
        yield MenuItem::linkToCrud('Horaires', 'fa fa-calendar-days', Schedule::class);   
        yield MenuItem::linkToCrud('Services', 'fa fa-list', Service::class); 
        yield MenuItem::linkToCrud('ServicesEmployés', 'fa fa-list', ServiceEmployee::class);   
    }
}
