<?php

namespace App\Controller\Admin;

use App\Entity\Car;
use App\Entity\Formulaire;
use App\Entity\Schedule;

use App\Entity\Service;
use App\Entity\Testimonials;
use App\Entity\User;
use Doctrine\ORM\Mapping\Entity;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class DashboardController extends AbstractDashboardController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(CarCrudController::class)->generateUrl());

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        
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
        yield MenuItem::linkToCrud('Voitures', 'fa fa-car', Car::class);  
        yield MenuItem::linkToCrud('Commentaires', 'fa fa-message', Testimonials::class);   
        yield MenuItem::linkToCrud('Contact', 'fa-brands fa-wpforms', Formulaire::class);
         
        
        if($this->isGranted('ROLE_ADMIN')){
            yield MenuItem::linkToCrud('Horaires', 'fa fa-calendar-days', Schedule::class);   
            yield MenuItem::linkToCrud('Utilisateurs', 'fa fa-users', User::class); 
            yield MenuItem::linkToCrud('Service', 'fa fa-list', Service::class); 
        }
}
}